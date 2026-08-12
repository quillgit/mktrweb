<?php
/**
 * Six legacy content tables -> one pages table.
 */

namespace Mktr\Import;

use Mktr\Core\Html;
use Mktr\Models\DocumentCategory;

class PagesImporter extends Importer
{
    /**
     * Legacy table => section. The first two are flat; the rest carry the
     * kategori/child hierarchy.
     *
     * @var array<string,string>
     */
    private $map = [
        'tabel_about_us'              => 'about',
        'tabel_bisnis_inti'           => 'business',
        'tabel_berkelanjutan'         => 'sustainability',
        'tabel_tatakelola_perusahaan' => 'governance',
        'tabel_tentang_kami'          => 'investor',
        'tabel_sumber_daya'           => 'hr',
    ];

    /**
     * tabel_about_us has no usable slug column — every row is empty or NULL.
     * The legacy routes are pinned to the row id in index.php's SEO chain
     * (id_about_us = '1' under sct=profil_kami, and so on), so the slugs are
     * reconstructed from that mapping rather than invented.
     *
     * @var array<int,string>
     */
    private $aboutSlugs = [
        1 => 'profil_kami',
        2 => 'logo_kami',
        3 => 'visi_misi',
        4 => 'struktur_kepemilikan',
        5 => 'struktur_group',
        6 => 'struktur_organisasi',
        7 => 'keanggotaan',
    ];

    /**
     * Pages whose `tipe` is 'dokumen' render a document listing. The legacy
     * code chose the table with a hardcoded branch per slug
     * (module/hubungan_investor.php); this is that mapping, read off the
     * production slugs.
     *
     * @var array<string,string> page slug => document category slug
     */
    private $documentPages = [
        // investor
        'laporan-tahunan'                            => 'laporan-tahunan',
        'laporan-keuangan'                           => 'laporan-keuangan',
        'prospektus'                                 => 'prospektus',
        'keterbukaan-informasi'                      => 'keterbukaan-informasi',
        'presentasi-perusahaan'                      => 'presentasi-perusahaan',
        'buletin-investor'                           => 'buletin-investor',
        'laporan-operasional'                        => 'laporan-operasional',
        // governance
        'anggaran-dasar'                             => 'anggaran-dasar',
        'rapat-umum-pemegang-saham'                  => 'rups',
        'transaksi-afiliasi'                         => 'transaksi-afiliasi',
        'kebijakan-tata-kelola-teknologi-informasi'  => 'kebijakan-tata-kelola',
        'pedoman-umum-governansi-korporat-indonesia' => 'pedoman',
        // sustainability
        'laporan-keberlanjutan'                      => 'laporan-keberlanjutan',
        'rspo'                                       => 'laporan-rspo',
        'iscc'                                       => 'iscc',
        'kebijakan-dan-pedoman-berkelanjutan'        => 'kebijakan',
        'pengumuman-sertifikat'                      => 'sertifikasi',
        'penilaian-kekayaan-keanekaragaman-hayati'   => 'laporan-kekayaan',
        'hcs-area-loss-recovery-plan'                => 'rencana-kerja',
    ];

    /** Rendered from the grievance register rather than a document category. */
    private $grievancePages = ['daftar-pengaduan'];

    public function name(): string
    {
        return 'pages';
    }

    public function run(): void
    {
        $categories = (new DocumentCategory())->slugMap();

        // legacy "<table>:<id>" => new page id, for the parent pass.
        $idMap = [];

        foreach ($this->map as $table => $section) {
            if (!$this->tableExists($table)) {
                $this->note(sprintf('%s: table not present in the legacy database, skipped', $table));
                continue;
            }

            $this->importTable($table, $section, $categories, $idMap);
        }

        $this->linkParents($idMap);
    }

    /**
     * @param array<string,int> $categories
     * @param array<string,int> $idMap
     */
    private function importTable(string $table, string $section, array $categories, array &$idMap): void
    {
        $primary = $this->firstColumn($table, [str_replace('tabel_', 'id_', $table), 'id']);

        if ($primary === null) {
            $this->note(sprintf('%s: no recognisable primary key, skipped', $table));
            return;
        }

        $hasHierarchy = $this->hasColumn($table, 'kategori') && $this->hasColumn($table, 'child');
        $hasType      = $this->hasColumn($table, 'tipe');
        // tabel_bisnis_inti keeps its long-form body in `konten`, not `description`.
        $bodyColumn   = $this->firstColumn($table, ['konten', 'description']);
        $bodyColumnEn = $this->firstColumn($table, ['konten_english', 'description_english']);

        $rows = $this->fetchAll('SELECT * FROM ' . $table);
        $this->count($table, 'source', count($rows));

        foreach ($rows as $index => $row) {
            $sourceId = isset($row[$primary]) ? (int) $row[$primary] : 0;

            if ($sourceId === 0) {
                $this->count($table, 'skipped');
                continue;
            }

            $title = $this->firstNonEmpty([
                isset($row['sub_title']) ? $row['sub_title'] : null,
                isset($row['title']) ? $row['title'] : null,
            ]);

            if ($title === '') {
                $this->count($table, 'skipped');
                $this->note(sprintf('%s: row %d has no title, skipped', $table, $sourceId));
                continue;
            }

            $ref  = $table . ':' . $sourceId;
            $slug = $this->uniqueSlug($section, $this->resolveSlug($table, $sourceId, $row, $title), $ref);

            $type       = 'text';
            $categoryId = null;

            if ($hasType && isset($row['tipe']) && $row['tipe'] === 'dokumen') {
                if (in_array($slug, $this->grievancePages, true)) {
                    $type = 'grievances';
                } else {
                    $type = 'documents';

                    if (isset($this->documentPages[$slug], $categories[$this->documentPages[$slug]])) {
                        $categoryId = (int) $categories[$this->documentPages[$slug]];
                    } else {
                        $this->note(sprintf(
                            '%s: document page "%s" has no matching document category; it will render empty',
                            $table,
                            $slug
                        ));
                    }
                }
            }

            $status = $this->mapStatus(isset($row['status']) ? $row['status'] : null);
            $created = $this->normaliseDate(isset($row['created']) ? $row['created'] : null);

            $attributes = [
                'section'              => $section,
                'type'                => $type,
                'slug'                => $slug,
                'document_category_id' => $categoryId,
                'banner_media_id'      => $this->registerFile(
                    isset($row['banner']) ? (string) $row['banner'] : null, 'images/banner', 'image', $table
                ),
                'banner_mobile_media_id' => $this->registerFile(
                    isset($row['banner_mobile']) ? (string) $row['banner_mobile'] : null, 'images/banner', 'image', $table
                ),
                'cover_media_id'       => $this->registerFile(
                    isset($row['gambar']) ? (string) $row['gambar'] : null, 'images/about', 'image', $table
                ),
                'sort'                 => $index,
                'status'               => $status,
                'published_at'         => $status === 'published'
                    ? ($created !== null ? $created : date('Y-m-d H:i:s'))
                    : null,
            ];

            $translations = [
                'id' => [
                    'slug'     => isset($row['slug']) && $row['slug'] !== '' ? (string) $row['slug'] : null,
                    'title'    => $title,
                    'subtitle' => isset($row['title']) ? (string) $row['title'] : null,
                    'body'     => $bodyColumn !== null && isset($row[$bodyColumn])
                        ? Html::sanitize((string) $row[$bodyColumn]) : null,
                ],
                'en' => [
                    'slug'     => isset($row['slug_english']) && $row['slug_english'] !== ''
                        ? (string) $row['slug_english'] : null,
                    'title'    => $this->firstNonEmpty([
                        isset($row['sub_title_english']) ? $row['sub_title_english'] : null,
                        $title,
                    ]),
                    'subtitle' => isset($row['title']) ? (string) $row['title'] : null,
                    'body'     => $bodyColumnEn !== null && isset($row[$bodyColumnEn])
                        ? Html::sanitize((string) $row[$bodyColumnEn]) : null,
                ],
            ];

            if ($this->dryRun) {
                $this->count($table, 'imported');
                continue;
            }

            $existing = $this->db->selectOne('SELECT id FROM pages WHERE legacy_ref = ? LIMIT 1', [$ref]);

            if ($existing === null) {
                $attributes['legacy_ref'] = $ref;
                $attributes['created_at'] = $created !== null ? $created : date('Y-m-d H:i:s');
                $attributes['updated_at'] = date('Y-m-d H:i:s');

                $pageId = $this->insertRow('pages', $attributes);
                $this->count($table, 'imported');
            } else {
                $pageId                   = (int) $existing['id'];
                $attributes['updated_at'] = date('Y-m-d H:i:s');

                $this->updateRow('pages', $pageId, $attributes);
                $this->count($table, 'updated');
            }

            $idMap[$ref] = $pageId;

            foreach ($translations as $locale => $fields) {
                $this->db->run(
                    'INSERT INTO page_translations (page_id, locale, slug, title, subtitle, body)
                     VALUES (?, ?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE
                        slug = VALUES(slug), title = VALUES(title),
                        subtitle = VALUES(subtitle), body = VALUES(body)',
                    [$pageId, $locale, $fields['slug'], $fields['title'], $fields['subtitle'], $fields['body']]
                );
            }

            // Remember the legacy parent pointer for the second pass.
            if ($hasHierarchy && isset($row['kategori']) && $row['kategori'] === 'child' && !empty($row['child'])) {
                $idMap['@parent:' . $ref] = $table . ':' . (int) $row['child'];
            }
        }
    }

    /**
     * Second pass: legacy `child` holds the parent's id in the same table, so
     * parents can only be resolved once every row has a new id.
     *
     * @param array<string,mixed> $idMap
     */
    private function linkParents(array $idMap): void
    {
        if ($this->dryRun) {
            return;
        }

        $linked  = 0;
        $orphans = 0;

        foreach ($idMap as $key => $value) {
            if (strpos($key, '@parent:') !== 0) {
                continue;
            }

            $childRef  = substr($key, 8);
            $parentRef = (string) $value;

            if (!isset($idMap[$childRef])) {
                continue;
            }

            if (!isset($idMap[$parentRef])) {
                $orphans++;
                $this->note(sprintf('%s: parent %s not found, left at top level', $childRef, $parentRef));
                continue;
            }

            $this->db->affected(
                'UPDATE pages SET parent_id = ? WHERE id = ?',
                [(int) $idMap[$parentRef], (int) $idMap[$childRef]]
            );

            $linked++;
        }

        $this->note(sprintf('hierarchy: %d child pages linked, %d orphaned', $linked, $orphans));
    }

    /**
     * `pages` is uniquely keyed on (section, slug). Two legacy rows in the same
     * section can produce the same slug, so a clash is suffixed with the source
     * id — which keeps the result stable across re-runs, unlike an incrementing
     * counter. A row keeping its own slug is not treated as a clash.
     */
    private function uniqueSlug(string $section, string $slug, string $ref): string
    {
        $slug = $slug === '' ? 'halaman' : $slug;

        if ($this->dryRun) {
            return $slug;
        }

        $owner = $this->db->selectOne(
            'SELECT legacy_ref FROM pages WHERE section = ? AND slug = ? LIMIT 1',
            [$section, $slug]
        );

        if ($owner === null || (string) $owner['legacy_ref'] === $ref) {
            return $slug;
        }

        $suffix = (string) substr(strrchr($ref, ':'), 1);

        $this->note(sprintf('slug clash in section "%s": %s taken, using %s-%s', $section, $slug, $slug, $suffix));

        return $slug . '-' . $suffix;
    }

    private function resolveSlug(string $table, int $sourceId, array $row, string $title): string
    {
        if ($table === 'tabel_about_us') {
            return isset($this->aboutSlugs[$sourceId])
                ? $this->aboutSlugs[$sourceId]
                : str_slug($title);
        }

        if (isset($row['slug']) && trim((string) $row['slug']) !== '') {
            return str_slug((string) $row['slug']);
        }

        return str_slug($title);
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
