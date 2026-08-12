<?php
/**
 * Site search.
 *
 * The legacy /cari/{slug} searched two tables — news and sustainability — with
 * `LIKE '%$search%'` interpolated straight into the SQL, and returned two
 * unlabelled lists. Here it covers everything published (pages, news,
 * documents, vacancies), binds the term, and labels each hit with what it is
 * so the result list is navigable.
 *
 * LIKE is deliberate rather than FULLTEXT: the corpus is a few hundred rows,
 * the content is bilingual (so one FULLTEXT stopword list would be wrong for
 * half of it), and a substring match is what an editor searching for "ISPO"
 * or "RUPS" expects.
 */

namespace Mktr\Support;

use Mktr\Core\Database;

class SiteSearch
{
    /** Hits returned per source, so one busy table cannot crowd out the rest. */
    const PER_SOURCE = 20;

    /** @var Database */
    private $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    /**
     * A search term as it appears in a /cari/{slug} URL: the legacy form
     * slugged the query, so the words come back hyphen-separated.
     */
    public static function fromSlug(string $slug): string
    {
        return trim(preg_replace('/[-_]+/', ' ', $slug));
    }

    /**
     * @return array<int,array<string,mixed>> [kind, title, excerpt, url_kind, id, slug]
     */
    public function search(string $term, string $locale, string $fallback): array
    {
        $term = trim($term);

        if (mb_strlen($term) < 2) {
            return [];
        }

        $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $term) . '%';

        return array_merge(
            $this->pages($like, $locale, $fallback),
            $this->posts($like, $locale, $fallback),
            $this->documents($like, $locale, $fallback),
            $this->jobs($like, $locale, $fallback)
        );
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function pages(string $like, string $locale, string $fallback): array
    {
        $rows = $this->db->select(
            "SELECT p.id, p.section, COALESCE(t.slug, p.slug) AS slug,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.body, f.body)   AS body
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
          LEFT JOIN page_translations f ON f.page_id = p.id AND f.locale = ?
              WHERE p.status = 'published' AND p.published_at IS NOT NULL AND p.published_at <= NOW()
                AND (COALESCE(t.title, f.title) LIKE ? OR COALESCE(t.body, f.body) LIKE ?)
           ORDER BY p.section, p.sort, p.id
              LIMIT " . self::PER_SOURCE,
            [$locale, $fallback, $like, $like]
        );

        return $this->shape($rows, 'page', function (array $row) {
            return ['section' => $row['section'], 'slug' => $row['slug']];
        });
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function posts(string $like, string $locale, string $fallback): array
    {
        $rows = $this->db->select(
            "SELECT p.id, p.slug, p.published_at,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.excerpt, f.excerpt, t.body, f.body) AS body
               FROM posts p
          LEFT JOIN post_translations t ON t.post_id = p.id AND t.locale = ?
          LEFT JOIN post_translations f ON f.post_id = p.id AND f.locale = ?
              WHERE p.status = 'published' AND p.published_at IS NOT NULL AND p.published_at <= NOW()
                AND (COALESCE(t.title, f.title) LIKE ? OR COALESCE(t.body, f.body) LIKE ?)
           ORDER BY p.published_at DESC
              LIMIT " . self::PER_SOURCE,
            [$locale, $fallback, $like, $like]
        );

        return $this->shape($rows, 'post', function (array $row) {
            return ['id' => $row['id'], 'slug' => $row['slug'], 'date' => $row['published_at']];
        });
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function documents(string $like, string $locale, string $fallback): array
    {
        $rows = $this->db->select(
            "SELECT d.id, d.document_date,
                    COALESCE(t.title, f.title)             AS title,
                    COALESCE(t.description, f.description) AS body
               FROM documents d
          LEFT JOIN document_translations t ON t.document_id = d.id AND t.locale = ?
          LEFT JOIN document_translations f ON f.document_id = d.id AND f.locale = ?
              WHERE d.status = 'published' AND d.published_at IS NOT NULL AND d.published_at <= NOW()
                AND COALESCE(t.title, f.title) LIKE ?
           ORDER BY d.document_date DESC, d.id DESC
              LIMIT " . self::PER_SOURCE,
            [$locale, $fallback, $like]
        );

        return $this->shape($rows, 'document', function (array $row) {
            return ['id' => $row['id'], 'date' => $row['document_date']];
        });
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function jobs(string $like, string $locale, string $fallback): array
    {
        $rows = $this->db->select(
            "SELECT j.id, j.slug,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.body, f.body)   AS body
               FROM jobs j
          LEFT JOIN job_translations t ON t.job_id = j.id AND t.locale = ?
          LEFT JOIN job_translations f ON f.job_id = j.id AND f.locale = ?
              WHERE j.status = 'published' AND j.published_at IS NOT NULL AND j.published_at <= NOW()
                AND (j.closes_on IS NULL OR j.closes_on >= CURDATE())
                AND (COALESCE(t.title, f.title) LIKE ? OR COALESCE(t.body, f.body) LIKE ?)
           ORDER BY j.published_at DESC
              LIMIT " . self::PER_SOURCE,
            [$locale, $fallback, $like, $like]
        );

        return $this->shape($rows, 'job', function (array $row) {
            return ['id' => $row['id'], 'slug' => $row['slug']];
        });
    }

    /**
     * @param  array<int,array<string,mixed>> $rows
     * @return array<int,array<string,mixed>>
     */
    private function shape(array $rows, string $kind, callable $target): array
    {
        $results = [];

        foreach ($rows as $row) {
            $results[] = [
                'kind'    => $kind,
                'title'   => (string) $row['title'],
                'excerpt' => \Mktr\Core\Html::excerpt((string) (isset($row['body']) ? $row['body'] : ''), 28),
                'target'  => $target($row),
            ];
        }

        return $results;
    }
}
