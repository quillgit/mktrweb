<?php
/**
 * tabel_lowongan_kerja -> jobs, and tabel_laporan_keluhan -> grievances.
 *
 * The second mapping is here rather than in DocumentsImporter because
 * tabel_laporan_keluhan is not a document table at all: it has no file column,
 * and its rows are grievance submissions carrying names, addresses, emails and
 * phone numbers. See migration 007.
 */

namespace Mktr\Import;

use Mktr\Models\Job;

class JobsImporter extends Importer
{
    const JOBS       = 'tabel_lowongan_kerja';
    const GRIEVANCES = 'tabel_laporan_keluhan';

    public function name(): string
    {
        return 'jobs';
    }

    public function run(): void
    {
        $this->importJobs();
        $this->importGrievances();
    }

    private function importJobs(): void
    {
        if (!$this->tableExists(self::JOBS)) {
            $this->note(self::JOBS . ': table not present, skipped');
            return;
        }

        $primary = $this->firstColumn(self::JOBS, ['id_lowongan_kerja', 'id']);

        if ($primary === null) {
            $this->note(self::JOBS . ': no recognisable primary key, skipped');
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM ' . self::JOBS);
        $this->count(self::JOBS, 'source', count($rows));

        $jobs = new Job();

        foreach ($rows as $row) {
            $sourceId = isset($row[$primary]) ? (int) $row[$primary] : 0;
            $title    = isset($row['title']) ? trim((string) $row['title']) : '';

            if ($sourceId === 0 || $title === '') {
                $this->count(self::JOBS, 'skipped');
                continue;
            }

            $ref     = self::JOBS . ':' . $sourceId;
            $created = $this->normaliseDate(isset($row['created']) ? $row['created'] : null);
            $status  = $this->mapStatus(isset($row['status']) ? $row['status'] : null);
            $coverId = $this->registerFile(
                isset($row['gambar']) ? (string) $row['gambar'] : null,
                'images/post',
                'image',
                self::JOBS
            );

            if ($this->dryRun) {
                $this->count(self::JOBS, 'imported');
                continue;
            }

            $slug = isset($row['slug']) && trim((string) $row['slug']) !== ''
                ? str_slug((string) $row['slug'])
                : str_slug($title);

            $existing = $this->db->selectOne('SELECT id FROM jobs WHERE legacy_ref = ? LIMIT 1', [$ref]);

            $attributes = [
                'cover_media_id' => $coverId,
                'status'         => $status,
                'published_at'   => $status === 'published'
                    ? ($created !== null ? $created : date('Y-m-d H:i:s'))
                    : null,
                'updated_at'     => date('Y-m-d H:i:s'),
            ];

            if ($existing === null) {
                $jobId = $this->db->insert(
                    'INSERT INTO jobs (slug, cover_media_id, status, published_at, legacy_ref, created_at, updated_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?)',
                    [
                        $jobs->uniqueSlug($slug),
                        $attributes['cover_media_id'],
                        $attributes['status'],
                        $attributes['published_at'],
                        $ref,
                        $created !== null ? $created : date('Y-m-d H:i:s'),
                        $attributes['updated_at'],
                    ]
                );
                $this->count(self::JOBS, 'imported');
            } else {
                $jobId = (int) $existing['id'];
                $this->db->affected(
                    'UPDATE jobs SET cover_media_id = ?, status = ?, published_at = ?, updated_at = ? WHERE id = ?',
                    [
                        $attributes['cover_media_id'],
                        $attributes['status'],
                        $attributes['published_at'],
                        $attributes['updated_at'],
                        $jobId,
                    ]
                );
                $this->count(self::JOBS, 'updated');
            }

            $body   = $this->cleanHtml(isset($row['content']) ? $row['content'] : null);
            $bodyEn = isset($row['content_english']) && trim((string) $row['content_english']) !== ''
                ? $this->cleanHtml($row['content_english'])
                : $body;

            $translations = [
                'id' => [
                    'slug'  => isset($row['slug']) && $row['slug'] !== '' ? (string) $row['slug'] : null,
                    'title' => $title,
                    'body'  => $body,
                ],
                'en' => [
                    'slug'  => isset($row['slug_english']) && $row['slug_english'] !== ''
                        ? (string) $row['slug_english'] : null,
                    'title' => isset($row['title_english']) && trim((string) $row['title_english']) !== ''
                        ? (string) $row['title_english'] : $title,
                    'body'  => $bodyEn,
                ],
            ];

            foreach ($translations as $locale => $fields) {
                $this->db->run(
                    'INSERT INTO job_translations (job_id, locale, slug, title, body, meta_description)
                     VALUES (?, ?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE
                        slug = VALUES(slug), title = VALUES(title), body = VALUES(body),
                        meta_description = VALUES(meta_description)',
                    [
                        $jobId,
                        $locale,
                        $fields['slug'],
                        $fields['title'],
                        $fields['body'],
                        isset($row['meta_description']) ? (string) $row['meta_description'] : null,
                    ]
                );
            }
        }
    }

    private function importGrievances(): void
    {
        if (!$this->tableExists(self::GRIEVANCES)) {
            $this->note(self::GRIEVANCES . ': table not present, skipped');
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM ' . self::GRIEVANCES);
        $this->count(self::GRIEVANCES, 'source', count($rows));

        foreach ($rows as $row) {
            $sourceId = isset($row['id_laporan_keluhan']) ? (int) $row['id_laporan_keluhan'] : 0;

            if ($sourceId === 0) {
                $this->count(self::GRIEVANCES, 'skipped');
                continue;
            }

            if ($this->dryRun) {
                $this->count(self::GRIEVANCES, 'imported');
                continue;
            }

            $ref        = self::GRIEVANCES . ':' . $sourceId;
            $reportedOn = $this->normaliseDate(isset($row['laporan_date']) ? $row['laporan_date'] : null);

            $attributes = [
                'reported_on'   => $reportedOn !== null ? substr($reportedOn, 0, 10) : null,
                'reporter_name' => isset($row['name']) ? (string) $row['name'] : null,
                'organization'  => isset($row['organization']) ? (string) $row['organization'] : null,
                'communication' => isset($row['communication']) ? (string) $row['communication'] : null,
                'email'         => isset($row['email']) ? (string) $row['email'] : null,
                'phone'         => isset($row['phone']) ? (string) $row['phone'] : null,
                'address'       => isset($row['address']) ? (string) $row['address'] : null,
                'case_status'   => isset($row['status_laporan']) && $row['status_laporan'] !== ''
                    ? (string) $row['status_laporan'] : 'laporan',
                'status'        => $this->mapStatus(isset($row['status']) ? $row['status'] : null) === 'published'
                    ? 'published' : 'draft',
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $existing = $this->db->selectOne('SELECT id FROM grievances WHERE legacy_ref = ? LIMIT 1', [$ref]);

            if ($existing === null) {
                $attributes['legacy_ref'] = $ref;
                $attributes['created_at'] = $this->normaliseDate(isset($row['created']) ? $row['created'] : null)
                    ?: date('Y-m-d H:i:s');

                $columns      = array_keys($attributes);
                $placeholders = array_fill(0, count($columns), '?');

                $this->db->insert(
                    sprintf('INSERT INTO grievances (%s) VALUES (%s)', implode(', ', $columns), implode(', ', $placeholders)),
                    array_values($attributes)
                );

                $this->count(self::GRIEVANCES, 'imported');
            } else {
                $assignments = [];
                foreach (array_keys($attributes) as $column) {
                    $assignments[] = $column . ' = ?';
                }

                $bindings   = array_values($attributes);
                $bindings[] = (int) $existing['id'];

                $this->db->affected(
                    sprintf('UPDATE grievances SET %s WHERE id = ?', implode(', ', $assignments)),
                    $bindings
                );

                $this->count(self::GRIEVANCES, 'updated');
            }
        }
    }
}
