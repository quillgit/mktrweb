<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class Document extends Model
{
    /** @var string */
    protected $table = 'documents';

    /** @var string[] */
    protected $sortable = ['id', 'document_date', 'year', 'sort', 'status', 'downloads', 'created_at'];

    /**
     * Same publishing rule as posts: published AND its go-live time has passed,
     * which is what makes scheduling work without a cron job.
     */
    private function publishedClause(string $alias = 'd'): string
    {
        return "{$alias}.status = 'published'"
            . " AND {$alias}.published_at IS NOT NULL"
            . " AND {$alias}.published_at <= NOW()";
    }

    /**
     * Published documents in a category, newest first, optionally limited to a
     * single year.
     *
     * @return array<int,array<string,mixed>>
     */
    public function publishedInCategory(
        int $categoryId,
        string $locale,
        string $fallback,
        ?int $year = null
    ): array {
        $bindings = [$locale, $fallback, $categoryId];
        $yearSql  = '';

        if ($year !== null) {
            $yearSql    = ' AND d.year = ?';
            $bindings[] = $year;
        }

        return $this->db()->select(
            'SELECT d.id, d.document_date, d.year, d.downloads,
                    COALESCE(t.title, f.title)             AS title,
                    COALESCE(t.description, f.description) AS description,
                    fm.path AS file_path, fm.size AS file_size, fm.mime AS file_mime,
                    cm.path AS cover_path, cm.alt AS cover_alt,
                    cm.width AS cover_width, cm.height AS cover_height
               FROM documents d
          LEFT JOIN document_translations t ON t.document_id = d.id AND t.locale = ?
          LEFT JOIN document_translations f ON f.document_id = d.id AND f.locale = ?
          LEFT JOIN media fm ON fm.id = d.file_media_id
          LEFT JOIN media cm ON cm.id = d.cover_media_id
              WHERE d.category_id = ? AND ' . $this->publishedClause() . $yearSql . '
           ORDER BY d.sort ASC, d.document_date DESC, d.id DESC',
            $bindings
        );
    }

    /**
     * Years that actually have published documents in this category, for the
     * filter control. Returns newest first.
     *
     * @return int[]
     */
    public function publishedYears(int $categoryId): array
    {
        $rows = $this->db()->select(
            'SELECT DISTINCT d.year
               FROM documents d
              WHERE d.category_id = ? AND d.year IS NOT NULL AND ' . $this->publishedClause() . '
           ORDER BY d.year DESC',
            [$categoryId]
        );

        return array_map(function (array $row) {
            return (int) $row['year'];
        }, $rows);
    }

    /**
     * Fetch a published document together with the file needed to serve it.
     *
     * @return array<string,mixed>|null
     */
    public function findPublishedWithFile(int $id, string $locale, string $fallback): ?array
    {
        return $this->db()->selectOne(
            'SELECT d.id, d.category_id,
                    COALESCE(t.title, f.title) AS title,
                    fm.path AS file_path, fm.filename AS file_name, fm.mime AS file_mime
               FROM documents d
          LEFT JOIN document_translations t ON t.document_id = d.id AND t.locale = ?
          LEFT JOIN document_translations f ON f.document_id = d.id AND f.locale = ?
          LEFT JOIN media fm ON fm.id = d.file_media_id
              WHERE d.id = ? AND ' . $this->publishedClause() . '
              LIMIT 1',
            [$locale, $fallback, $id]
        );
    }

    public function incrementDownloads(int $id): void
    {
        $this->db()->affected('UPDATE documents SET downloads = downloads + 1 WHERE id = ?', [$id]);
    }

    /* ---- admin ----------------------------------------------------------- */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function adminPage(
        string $defaultLocale,
        int $limit,
        int $offset,
        int $categoryId = 0,
        string $status = '',
        ?int $year = null
    ): array {
        $where    = ['1 = 1'];
        $bindings = [$defaultLocale, $defaultLocale];

        if ($categoryId > 0) {
            $where[]    = 'd.category_id = ?';
            $bindings[] = $categoryId;
        }

        if ($status !== '') {
            $where[]    = 'd.status = ?';
            $bindings[] = $status;
        }

        if ($year !== null) {
            $where[]    = 'd.year = ?';
            $bindings[] = $year;
        }

        $bindings[] = $limit;
        $bindings[] = $offset;

        return $this->db()->select(
            'SELECT d.id, d.status, d.document_date, d.year, d.downloads, d.updated_at,
                    t.title AS title,
                    ct.name AS category_name,
                    c.slug  AS category_slug,
                    fm.path AS file_path,
                    cm.path AS cover_path
               FROM documents d
          LEFT JOIN document_translations t ON t.document_id = d.id AND t.locale = ?
               JOIN document_categories c ON c.id = d.category_id
          LEFT JOIN document_category_translations ct ON ct.category_id = c.id AND ct.locale = ?
          LEFT JOIN media fm ON fm.id = d.file_media_id
          LEFT JOIN media cm ON cm.id = d.cover_media_id
              WHERE ' . implode(' AND ', $where) . '
           ORDER BY d.updated_at DESC, d.id DESC
              LIMIT ? OFFSET ?',
            $bindings
        );
    }

    public function adminCount(int $categoryId = 0, string $status = '', ?int $year = null): int
    {
        $where    = ['1 = 1'];
        $bindings = [];

        if ($categoryId > 0) {
            $where[]    = 'category_id = ?';
            $bindings[] = $categoryId;
        }

        if ($status !== '') {
            $where[]    = 'status = ?';
            $bindings[] = $status;
        }

        if ($year !== null) {
            $where[]    = 'year = ?';
            $bindings[] = $year;
        }

        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM documents WHERE ' . implode(' AND ', $where),
            $bindings
        );
    }

    /**
     * @return array<string,array<string,mixed>> keyed by locale
     */
    public function translations(int $documentId): array
    {
        $rows  = $this->db()->select('SELECT * FROM document_translations WHERE document_id = ?', [$documentId]);
        $keyed = [];

        foreach ($rows as $row) {
            $keyed[(string) $row['locale']] = $row;
        }

        return $keyed;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findByLegacyRef(string $ref): ?array
    {
        return $this->db()->selectOne('SELECT * FROM documents WHERE legacy_ref = ? LIMIT 1', [$ref]);
    }

    /**
     * @param array<string,array<string,string>> $translations locale => fields
     */
    public function createWithTranslations(array $document, array $translations): int
    {
        return $this->db()->transaction(function () use ($document, $translations) {
            $document['created_at'] = date('Y-m-d H:i:s');
            $document['updated_at'] = $document['created_at'];

            $id = $this->insert($document);
            $this->saveTranslations($id, $translations);

            return $id;
        });
    }

    /**
     * @param array<string,array<string,string>> $translations locale => fields
     */
    public function updateWithTranslations(int $id, array $document, array $translations): void
    {
        $this->db()->transaction(function () use ($id, $document, $translations) {
            $document['updated_at'] = date('Y-m-d H:i:s');

            $this->update($id, $document);
            $this->saveTranslations($id, $translations);
        });
    }

    /**
     * @param array<string,array<string,string>> $translations
     */
    private function saveTranslations(int $documentId, array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            $this->db()->run(
                'INSERT INTO document_translations (document_id, locale, title, description)
                 VALUES (?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description)',
                [
                    $documentId,
                    $locale,
                    isset($fields['title']) ? $fields['title'] : '',
                    isset($fields['description']) ? $fields['description'] : null,
                ]
            );
        }
    }

    /**
     * All years present across every category, for the admin filter.
     *
     * @return int[]
     */
    public function allYears(): array
    {
        $rows = $this->db()->select(
            'SELECT DISTINCT year FROM documents WHERE year IS NOT NULL ORDER BY year DESC'
        );

        return array_map(function (array $row) {
            return (int) $row['year'];
        }, $rows);
    }
}
