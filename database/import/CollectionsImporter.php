<?php
/**
 * Six small legacy tables -> collection_items, plus the two submission tables
 * -> inquiries.
 */

namespace Mktr\Import;

use Mktr\Core\Html;

class CollectionsImporter extends Importer
{
    /**
     * table => [kind, image directory, body column, body column (en)]
     *
     * @var array<string,array{0:string,1:string,2:?string,3:?string}>
     */
    private $map = [
        'tabel_struktur_organisasi' => ['leadership', 'images/manajemen', 'description', 'description_english'],
        'tabel_perusahaan'          => ['subsidiary', 'images/about',     'description', 'description_english'],
        'tabel_penghargaan'         => ['award',      'images/penghargaan', 'content',   'content_english'],
        'tabel_keanggotaan'         => ['membership', 'images/about',       'content',   'content_english'],
        'tabel_jejak_perusahaan'    => ['milestone',  'images/banner',    'description', 'description_english'],
        'tabel_banner'              => ['banner',     'images/banner',    'konten',      'konten_english'],
    ];

    public function name(): string
    {
        return 'collections';
    }

    public function run(): void
    {
        foreach ($this->map as $table => $spec) {
            if (!$this->tableExists($table)) {
                $this->note(sprintf('%s: table not present, skipped', $table));
                continue;
            }

            $this->importTable($table, $spec[0], $spec[1], $spec[2], $spec[3]);
        }

        $this->importContactInbox();
        $this->importWhistleblower();
    }

    private function importTable(string $table, string $kind, string $directory, ?string $bodyCol, ?string $bodyColEn): void
    {
        $primary = $this->firstColumn($table, [str_replace('tabel_', 'id_', $table), 'id']);

        if ($primary === null) {
            $this->note(sprintf('%s: no recognisable primary key, skipped', $table));
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM ' . $table);
        $this->count($table, 'source', count($rows));

        // tabel_struktur_organisasi orders by `urutan`, the others by row order.
        $orderCol = $this->hasColumn($table, 'urutan') ? 'urutan' : null;

        foreach ($rows as $index => $row) {
            $sourceId = isset($row[$primary]) ? (int) $row[$primary] : 0;

            /*
             * `title` is the heading in every one of these tables and
             * `sub_title` the line under it — the person's name over their
             * role, the company over its line of business, the year over the
             * company name. Reading them the other way round is what the
             * first pass did, and it put "Komisaris Utama" where the name
             * belonged. `sub_title` is only a fallback for rows that have no
             * title at all.
             */
            $title    = $this->cleanText($this->firstNonEmpty([
                isset($row['title']) ? $row['title'] : null,
                isset($row['sub_title']) ? $row['sub_title'] : null,
            ]));
            $subtitle = $this->cleanText($this->firstNonEmpty([isset($row['sub_title']) ? $row['sub_title'] : null]));

            /*
             * Three of the six tables carry no `title_english`: names of
             * people and companies are the same in both locales, so the
             * Indonesian title stands in rather than the English sub-title
             * being promoted into the heading.
             */
            $titleEn    = $this->cleanText($this->firstNonEmpty([
                isset($row['title_english']) ? $row['title_english'] : null,
                $title,
            ]));
            $subtitleEn = $this->cleanText($this->firstNonEmpty([
                isset($row['sub_title_english']) ? $row['sub_title_english'] : null,
                $subtitle,
            ]));

            if ($sourceId === 0 || $title === '') {
                $this->count($table, 'skipped');
                $this->note(sprintf('%s: row %d has no id or title, skipped', $table, $sourceId));
                continue;
            }

            $ref    = $table . ':' . $sourceId;
            $status = $this->mapStatus(isset($row['status']) ? $row['status'] : null);

            $attributes = [
                'kind'                  => $kind,
                'group_key'             => $this->hasColumn($table, 'kategori') && !empty($row['kategori'])
                    ? (string) $row['kategori'] : null,
                'slug'                  => null, // set below once uniqueness is known
                'image_media_id'        => $this->registerFile(
                    isset($row['gambar']) ? (string) $row['gambar'] : null, $directory, 'image', $table
                ),
                'detail_image_media_id' => $this->hasColumn($table, 'gambar_detail')
                    ? $this->registerFile(
                        isset($row['gambar_detail']) ? (string) $row['gambar_detail'] : null,
                        $directory, 'image', $table
                    )
                    : null,
                'mobile_image_media_id' => $this->hasColumn($table, 'gambar_mobile')
                    ? $this->registerFile(
                        isset($row['gambar_mobile']) ? (string) $row['gambar_mobile'] : null,
                        'images/banner', 'image', $table
                    )
                    : null,
                'link'                  => $this->hasColumn($table, 'link') && !empty($row['link'])
                    ? (string) $row['link'] : null,
                'sort'                  => $orderCol !== null && isset($row[$orderCol])
                    ? (int) $row[$orderCol] : $index,
                'status'                => $status === 'published' ? 'published' : 'draft',
                'published_at'          => $status === 'published'
                    ? ($this->normaliseDate(isset($row['created']) ? $row['created'] : null) ?: date('Y-m-d H:i:s'))
                    : null,
            ];

            if ($this->dryRun) {
                $this->count($table, 'imported');
                continue;
            }

            $slugSource = isset($row['slug']) && trim((string) $row['slug']) !== ''
                ? (string) $row['slug']
                : $title;

            $attributes['slug'] = $this->uniqueSlug($kind, str_slug($slugSource), $ref);

            $existing = $this->db->selectOne('SELECT id FROM collection_items WHERE legacy_ref = ? LIMIT 1', [$ref]);

            if ($existing === null) {
                $attributes['legacy_ref'] = $ref;
                $attributes['created_at'] = date('Y-m-d H:i:s');
                $attributes['updated_at'] = $attributes['created_at'];

                $itemId = $this->insertRow('collection_items', $attributes);
                $this->count($table, 'imported');
            } else {
                $itemId                   = (int) $existing['id'];
                $attributes['updated_at'] = date('Y-m-d H:i:s');

                $this->updateRow('collection_items', $itemId, $attributes);
                $this->count($table, 'updated');
            }

            $translations = [
                'id' => [
                    'title'    => $title,
                    'subtitle' => $subtitle === '' ? null : $subtitle,
                    'body'     => $bodyCol !== null && isset($row[$bodyCol])
                        ? Html::sanitize((string) $row[$bodyCol]) : null,
                ],
                'en' => [
                    'title'    => $titleEn,
                    'subtitle' => $subtitleEn === '' ? null : $subtitleEn,
                    'body'     => $bodyColEn !== null && isset($row[$bodyColEn])
                        ? Html::sanitize((string) $row[$bodyColEn]) : null,
                ],
            ];

            foreach ($translations as $locale => $fields) {
                $this->db->run(
                    'INSERT INTO collection_item_translations (item_id, locale, title, subtitle, body)
                     VALUES (?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE title = VALUES(title), subtitle = VALUES(subtitle), body = VALUES(body)',
                    [$itemId, $locale, $fields['title'], $fields['subtitle'], $fields['body']]
                );
            }
        }
    }

    /**
     * msg_inbox -> inquiries(kind = contact).
     */
    private function importContactInbox(): void
    {
        if (!$this->tableExists('msg_inbox')) {
            $this->note('msg_inbox: table not present, skipped');
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM msg_inbox');
        $this->count('msg_inbox', 'source', count($rows));

        foreach ($rows as $row) {
            $sourceId = isset($row['id']) ? (int) $row['id'] : 0;

            if ($sourceId === 0) {
                $this->count('msg_inbox', 'skipped');
                continue;
            }

            if ($this->dryRun) {
                $this->count('msg_inbox', 'imported');
                continue;
            }

            $this->upsertInquiry('msg_inbox:' . $sourceId, [
                'kind'       => 'contact',
                'name'       => isset($row['name']) ? (string) $row['name'] : null,
                'email'      => isset($row['email']) ? (string) $row['email'] : null,
                'phone'      => isset($row['no_hp']) ? (string) $row['no_hp'] : null,
                'subject'    => isset($row['subject']) ? (string) $row['subject'] : null,
                'message'    => isset($row['message']) ? (string) $row['message'] : null,
                'payload'    => null,
                'status'     => 'read',
                'created_at' => $this->normaliseDate(isset($row['created']) ? $row['created'] : null) ?: date('Y-m-d H:i:s'),
            ], 'msg_inbox');
        }
    }

    /**
     * tabel_pelaporan_pelanggaran -> inquiries(kind = whistleblower).
     *
     * The report-specific fields (who is being reported, when, where, the
     * amount involved) go in payload rather than becoming columns nothing else
     * would use.
     */
    private function importWhistleblower(): void
    {
        $table = 'tabel_pelaporan_pelanggaran';

        if (!$this->tableExists($table)) {
            $this->note($table . ': table not present, skipped');
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM ' . $table);
        $this->count($table, 'source', count($rows));

        foreach ($rows as $row) {
            $sourceId = isset($row['id_pelaporan_pelanggaran']) ? (int) $row['id_pelaporan_pelanggaran'] : 0;

            if ($sourceId === 0) {
                $this->count($table, 'skipped');
                continue;
            }

            if ($this->dryRun) {
                $this->count($table, 'imported');
                continue;
            }

            $payload = array_filter([
                'reported_name'     => isset($row['nama_terlapor']) ? (string) $row['nama_terlapor'] : null,
                'reported_position' => isset($row['jabatan_terlapor']) ? (string) $row['jabatan_terlapor'] : null,
                'occurred_at'       => isset($row['waktu_kejadian']) ? (string) $row['waktu_kejadian'] : null,
                'location'          => isset($row['lokasi_kejadian']) ? (string) $row['lokasi_kejadian'] : null,
                'amount'            => isset($row['nominal']) ? (string) $row['nominal'] : null,
            ], function ($value) {
                return $value !== null && $value !== '';
            });

            $this->upsertInquiry($table . ':' . $sourceId, [
                'kind'       => 'whistleblower',
                'name'       => isset($row['nama_pelapor']) ? (string) $row['nama_pelapor'] : null,
                'email'      => isset($row['email_pelapor']) ? (string) $row['email_pelapor'] : null,
                'phone'      => isset($row['telepon_pelapor']) ? (string) $row['telepon_pelapor'] : null,
                'subject'    => null,
                'message'    => isset($row['kronologis_kejadian']) ? (string) $row['kronologis_kejadian'] : null,
                'payload'    => $payload === [] ? null : (string) json_encode($payload, JSON_UNESCAPED_UNICODE),
                'status'     => 'read',
                'created_at' => $this->normaliseDate(isset($row['created']) ? $row['created'] : null) ?: date('Y-m-d H:i:s'),
            ], $table);
        }
    }

    /**
     * @param array<string,mixed> $attributes
     */
    private function upsertInquiry(string $ref, array $attributes, string $sourceTable): void
    {
        $existing = $this->db->selectOne('SELECT id FROM inquiries WHERE legacy_ref = ? LIMIT 1', [$ref]);

        if ($existing === null) {
            $attributes['legacy_ref'] = $ref;

            $columns      = array_keys($attributes);
            $placeholders = array_fill(0, count($columns), '?');

            $this->db->insert(
                sprintf('INSERT INTO inquiries (%s) VALUES (%s)', implode(', ', $columns), implode(', ', $placeholders)),
                array_values($attributes)
            );

            $this->count($sourceTable, 'imported');
            return;
        }

        unset($attributes['created_at']);

        $assignments = [];
        foreach (array_keys($attributes) as $column) {
            $assignments[] = $column . ' = ?';
        }

        $bindings   = array_values($attributes);
        $bindings[] = (int) $existing['id'];

        $this->db->affected(
            sprintf('UPDATE inquiries SET %s WHERE id = ?', implode(', ', $assignments)),
            $bindings
        );

        $this->count($sourceTable, 'updated');
    }

    private function uniqueSlug(string $kind, string $slug, string $ref): string
    {
        $slug = $slug === '' ? 'item' : $slug;

        $owner = $this->db->selectOne(
            'SELECT legacy_ref FROM collection_items WHERE kind = ? AND slug = ? LIMIT 1',
            [$kind, $slug]
        );

        if ($owner === null || (string) $owner['legacy_ref'] === $ref) {
            return $slug;
        }

        return $slug . '-' . substr(strrchr($ref, ':'), 1);
    }

    /**
     * @param array<int,mixed> $candidates
     */
    private function firstNonEmpty(array $candidates): string
    {
        foreach ($candidates as $candidate) {
            if ($candidate !== null && trim((string) $candidate) !== '') {
                return trim((string) $candidate);
            }
        }

        return '';
    }

    private function insertRow(string $table, array $data): int
    {
        $columns      = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');

        return $this->db->insert(
            sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, implode(', ', $columns), implode(', ', $placeholders)),
            array_values($data)
        );
    }

    private function updateRow(string $table, int $id, array $data): void
    {
        $assignments = [];
        foreach (array_keys($data) as $column) {
            $assignments[] = $column . ' = ?';
        }

        $bindings   = array_values($data);
        $bindings[] = $id;

        $this->db->affected(
            sprintf('UPDATE %s SET %s WHERE id = ?', $table, implode(', ', $assignments)),
            $bindings
        );
    }
}
