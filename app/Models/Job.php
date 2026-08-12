<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class Job extends Model
{
    /** @var string */
    protected $table = 'jobs';

    /** @var string[] */
    protected $sortable = ['id', 'slug', 'closes_on', 'status', 'created_at'];

    private function publishedClause(string $alias = 'j'): string
    {
        return "{$alias}.status = 'published'"
            . " AND {$alias}.published_at IS NOT NULL"
            . " AND {$alias}.published_at <= NOW()";
    }

    /**
     * Open vacancies. A job past its closing date drops off the listing
     * automatically rather than needing an editor to unpublish it.
     *
     * @return array<int,array<string,mixed>>
     */
    public function open(string $locale, string $fallback): array
    {
        return $this->db()->select(
            'SELECT j.id, j.slug, j.location, j.closes_on, j.published_at,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.slug, j.slug)   AS locale_slug,
                    m.path AS cover_path
               FROM jobs j
          LEFT JOIN job_translations t ON t.job_id = j.id AND t.locale = ?
          LEFT JOIN job_translations f ON f.job_id = j.id AND f.locale = ?
          LEFT JOIN media m ON m.id = j.cover_media_id
              WHERE ' . $this->publishedClause() . '
                AND (j.closes_on IS NULL OR j.closes_on >= CURDATE())
           ORDER BY j.published_at DESC, j.id DESC',
            [$locale, $fallback]
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findPublished(int $id, string $locale, string $fallback): ?array
    {
        return $this->db()->selectOne(
            'SELECT j.id, j.slug, j.location, j.closes_on, j.published_at,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.body, f.body)   AS body,
                    COALESCE(t.meta_title, f.meta_title)             AS meta_title,
                    COALESCE(t.meta_description, f.meta_description) AS meta_description,
                    m.path AS cover_path
               FROM jobs j
          LEFT JOIN job_translations t ON t.job_id = j.id AND t.locale = ?
          LEFT JOIN job_translations f ON f.job_id = j.id AND f.locale = ?
          LEFT JOIN media m ON m.id = j.cover_media_id
              WHERE j.id = ? AND ' . $this->publishedClause() . '
              LIMIT 1',
            [$locale, $fallback, $id]
        );
    }

    /* ---- admin ----------------------------------------------------------- */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function adminPage(string $defaultLocale, int $limit, int $offset): array
    {
        return $this->db()->select(
            'SELECT j.id, j.slug, j.status, j.location, j.closes_on, j.updated_at,
                    t.title AS title
               FROM jobs j
          LEFT JOIN job_translations t ON t.job_id = j.id AND t.locale = ?
           ORDER BY j.updated_at DESC, j.id DESC
              LIMIT ? OFFSET ?',
            [$defaultLocale, $limit, $offset]
        );
    }

    /**
     * @return array<string,array<string,mixed>> keyed by locale
     */
    public function translations(int $jobId): array
    {
        $rows  = $this->db()->select('SELECT * FROM job_translations WHERE job_id = ?', [$jobId]);
        $keyed = [];

        foreach ($rows as $row) {
            $keyed[(string) $row['locale']] = $row;
        }

        return $keyed;
    }

    public function uniqueSlug(string $slug, int $ignoreId = 0): string
    {
        $slug = $slug === '' ? 'lowongan' : $slug;
        $base = $slug;
        $n    = 2;

        while (true) {
            $exists = $this->db()->scalar(
                'SELECT id FROM jobs WHERE slug = ? AND id <> ? LIMIT 1',
                [$slug, $ignoreId]
            );

            if ($exists === false || $exists === null) {
                return $slug;
            }

            $slug = $base . '-' . $n;
            $n++;
        }
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    public function createWithTranslations(array $job, array $translations): int
    {
        return $this->db()->transaction(function () use ($job, $translations) {
            $job['created_at'] = date('Y-m-d H:i:s');
            $job['updated_at'] = $job['created_at'];

            $id = $this->insert($job);
            $this->saveTranslations($id, $translations);

            return $id;
        });
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    public function updateWithTranslations(int $id, array $job, array $translations): void
    {
        $this->db()->transaction(function () use ($id, $job, $translations) {
            $job['updated_at'] = date('Y-m-d H:i:s');

            $this->update($id, $job);
            $this->saveTranslations($id, $translations);
        });
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    private function saveTranslations(int $jobId, array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            $this->db()->run(
                'INSERT INTO job_translations (job_id, locale, slug, title, body, meta_title, meta_description)
                 VALUES (?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    slug = VALUES(slug), title = VALUES(title), body = VALUES(body),
                    meta_title = VALUES(meta_title), meta_description = VALUES(meta_description)',
                [
                    $jobId,
                    $locale,
                    isset($fields['slug']) && $fields['slug'] !== '' ? $fields['slug'] : null,
                    isset($fields['title']) ? $fields['title'] : '',
                    isset($fields['body']) ? $fields['body'] : null,
                    isset($fields['meta_title']) ? $fields['meta_title'] : null,
                    isset($fields['meta_description']) ? $fields['meta_description'] : null,
                ]
            );
        }
    }
}
