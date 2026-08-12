<?php
/**
 * 19 tabel_laporan_* tables -> one documents table.
 */

namespace Mktr\Import;

use Mktr\Models\DocumentCategory;

class DocumentsImporter extends Importer
{
    /**
     * Legacy table => category slug seeded by migration 005.
     * `setifikasi` is the legacy spelling and is intentionally preserved on the
     * left-hand side.
     *
     * @var array<string,string>
     */
    private $map = [
        'tabel_laporan_tahunan'                => 'laporan-tahunan',
        'tabel_laporan_keberlanjutan'          => 'laporan-keberlanjutan',
        'tabel_laporan_keuangan'               => 'laporan-keuangan',
        'tabel_laporan_prospektus'             => 'prospektus',
        'tabel_laporan_keterbukaan_informasi'  => 'keterbukaan-informasi',
        'tabel_laporan_presentasi_perusahaan'  => 'presentasi-perusahaan',
        'tabel_laporan_buletin_investor'       => 'buletin-investor',
        'tabel_laporan_operasional'            => 'laporan-operasional',
        'tabel_laporan_rups'                   => 'rups',
        'tabel_laporan_anggaran_dasar'         => 'anggaran-dasar',
        'tabel_laporan_kebijakan'              => 'kebijakan',
        'tabel_laporan_kebijakan_tatakelola'   => 'kebijakan-tata-kelola',
        'tabel_laporan_pedoman'                => 'pedoman',
        'tabel_laporan_kekayaan'               => 'laporan-kekayaan',
        'tabel_laporan_transaksi_afiliasi'     => 'transaksi-afiliasi',
        'tabel_laporan_setifikasi'             => 'sertifikasi',
        'tabel_laporan_rspo'                   => 'laporan-rspo',
        'tabel_laporan_plan'                   => 'rencana-kerja',
        'tabel_laporan_ispo'                   => 'ispo',
    ];

    /*
     * tabel_laporan_keluhan is deliberately absent from the map above.
     *
     * Despite the name it is not a report table: its columns are name,
     * organization, address, email, phone, communication and status_laporan,
     * and it has no file column at all. Those are grievance submissions, and
     * importing them here would have published complainants' contact details
     * in a public download list. GrievancesImporter handles them instead.
     */

    public function name(): string
    {
        return 'documents';
    }

    public function run(): void
    {
        $categories = (new DocumentCategory())->slugMap();

        foreach ($this->map as $table => $slug) {
            if (!$this->tableExists($table)) {
                $this->note(sprintf('%s: table not present in the legacy database, skipped', $table));
                continue;
            }

            if (!isset($categories[$slug])) {
                $this->note(sprintf('%s: no category "%s" in the new schema, skipped', $table, $slug));
                continue;
            }

            $this->importTable($table, (int) $categories[$slug]);
        }
    }

    private function importTable(string $table, int $categoryId): void
    {
        // The primary key follows the table name: tabel_laporan_tahunan ->
        // id_laporan_tahunan. Fall back to `id` if that is not there.
        $primary = $this->firstColumn($table, [
            str_replace('tabel_', 'id_', $table),
            'id',
        ]);

        if ($primary === null) {
            $this->note(sprintf('%s: no recognisable primary key, skipped', $table));
            return;
        }

        // Column drift across the legacy tables; take whichever exists.
        $dateColumn  = $this->firstColumn($table, ['laporan_date', 'tanggal', 'created']);
        $titleEn     = $this->hasColumn($table, 'title_english') ? 'title_english' : null;
        $subTitle    = $this->hasColumn($table, 'sub_title') ? 'sub_title' : null;
        $subTitleEn  = $this->hasColumn($table, 'sub_title_english') ? 'sub_title_english' : null;
        $coverColumn = $this->hasColumn($table, 'gambar') ? 'gambar' : null;
        $fileColumn  = $this->firstColumn($table, ['file_dokumen', 'file', 'dokumen']);
        $statusCol   = $this->hasColumn($table, 'status') ? 'status' : null;

        $rows = $this->fetchAll('SELECT * FROM ' . $table);

        $this->count($table, 'source', count($rows));

        foreach ($rows as $row) {
            $sourceId = isset($row[$primary]) ? (int) $row[$primary] : 0;
            $title    = isset($row['title']) ? trim((string) $row['title']) : '';

            if ($sourceId === 0 || $title === '') {
                $this->count($table, 'skipped');
                $this->note(sprintf('%s: row %d has no id or title, skipped', $table, $sourceId));
                continue;
            }

            $ref = $table . ':' . $sourceId;

            $coverId = $coverColumn !== null
                ? $this->registerFile(isset($row[$coverColumn]) ? (string) $row[$coverColumn] : null, 'images/post', 'image', $table)
                : null;

            $fileId = $fileColumn !== null
                ? $this->registerFile(isset($row[$fileColumn]) ? (string) $row[$fileColumn] : null, 'dokumen', 'document', $table)
                : null;

            $rawDate      = $dateColumn !== null && isset($row[$dateColumn]) ? $row[$dateColumn] : null;
            $documentDate = $this->normaliseDate($rawDate);
            $status       = $statusCol !== null ? $this->mapStatus($row[$statusCol]) : 'draft';

            $attributes = [
                'category_id'    => $categoryId,
                'file_media_id'  => $fileId,
                'cover_media_id' => $coverId,
                'document_date'  => $documentDate !== null ? substr($documentDate, 0, 10) : null,
                'year'           => $documentDate !== null ? (int) substr($documentDate, 0, 4) : null,
                'status'         => $status,
                'published_at'   => $status === 'published'
                    ? ($documentDate !== null ? $documentDate : date('Y-m-d H:i:s'))
                    : null,
            ];

            $translations = [
                'id' => [
                    'title'       => $title,
                    'description' => $subTitle !== null && isset($row[$subTitle]) ? (string) $row[$subTitle] : null,
                ],
                'en' => [
                    'title'       => $titleEn !== null && trim((string) $row[$titleEn]) !== ''
                        ? (string) $row[$titleEn]
                        : $title,
                    'description' => $subTitleEn !== null && isset($row[$subTitleEn]) ? (string) $row[$subTitleEn] : null,
                ],
            ];

            if ($this->dryRun) {
                $this->count($table, 'imported');
                continue;
            }

            $existing = $this->db->selectOne('SELECT id FROM documents WHERE legacy_ref = ? LIMIT 1', [$ref]);

            if ($existing === null) {
                $attributes['legacy_ref'] = $ref;
                $attributes['created_at'] = date('Y-m-d H:i:s');
                $attributes['updated_at'] = $attributes['created_at'];

                $documentId = $this->insertRow('documents', $attributes);
                $this->count($table, 'imported');
            } else {
                $documentId               = (int) $existing['id'];
                $attributes['updated_at'] = date('Y-m-d H:i:s');

                $this->updateRow('documents', $documentId, $attributes);
                $this->count($table, 'updated');
            }

            foreach ($translations as $locale => $fields) {
                $this->db->run(
                    'INSERT INTO document_translations (document_id, locale, title, description)
                     VALUES (?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description)',
                    [$documentId, $locale, $fields['title'], $fields['description']]
                );
            }
        }
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
