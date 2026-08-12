<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class Page extends Model
{
    /** @var string */
    protected $table = 'pages';

    /** @var string[] */
    protected $sortable = ['id', 'slug', 'sort', 'section', 'status', 'created_at'];

    /** @var string[] */
    public static $sections = ['about', 'business', 'sustainability', 'governance', 'investor', 'hr'];

    private function publishedClause(string $alias = 'p'): string
    {
        return "{$alias}.status = 'published'"
            . " AND {$alias}.published_at IS NOT NULL"
            . " AND {$alias}.published_at <= NOW()";
    }

    /**
     * Resolve a page from its section and slug.
     *
     * The legacy tables carry both `slug` and `slug_english`, so a page can be
     * reached by either its canonical slug or the slug for the active locale.
     *
     * @return array<string,mixed>|null
     */
    public function findBySlug(string $section, string $slug, string $locale, string $fallback): ?array
    {
        return $this->db()->selectOne(
            'SELECT p.id, p.section, p.parent_id, p.type, p.slug, p.document_category_id,
                    COALESCE(t.title, f.title)       AS title,
                    COALESCE(t.subtitle, f.subtitle) AS subtitle,
                    COALESCE(t.body, f.body)         AS body,
                    COALESCE(t.meta_title, f.meta_title)             AS meta_title,
                    COALESCE(t.meta_description, f.meta_description) AS meta_description,
                    COALESCE(t.slug, p.slug)         AS locale_slug,
                    b.path  AS banner_path,
                    bm.path AS banner_mobile_path,
                    c.slug  AS category_slug,
                    c.layout AS category_layout
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
          LEFT JOIN page_translations f ON f.page_id = p.id AND f.locale = ?
          LEFT JOIN media b  ON b.id  = p.banner_media_id
          LEFT JOIN media bm ON bm.id = p.banner_mobile_media_id
          LEFT JOIN document_categories c ON c.id = p.document_category_id
              WHERE p.section = ?
                AND (p.slug = ? OR t.slug = ? OR f.slug = ?)
                AND ' . $this->publishedClause() . '
              LIMIT 1',
            [$locale, $fallback, $section, $slug, $slug, $slug]
        );
    }

    /**
     * Sibling pages for the section sidebar: top-level entries plus their
     * children, in display order.
     *
     * @return array<int,array<string,mixed>>
     */
    public function sectionTree(string $section, string $locale, string $fallback): array
    {
        return $this->db()->select(
            'SELECT p.id, p.parent_id, p.slug, p.type,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.slug, p.slug)   AS locale_slug
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
          LEFT JOIN page_translations f ON f.page_id = p.id AND f.locale = ?
              WHERE p.section = ? AND ' . $this->publishedClause() . '
           ORDER BY COALESCE(p.parent_id, p.id), p.parent_id IS NOT NULL, p.sort, p.id',
            [$locale, $fallback, $section]
        );
    }

    /**
     * Top-level pages of a section with the bits a card needs — subtitle and
     * cover image — for the home page.
     *
     * module/home.php selected these by hardcoded primary key
     * (`id_berkelanjutan = '43'`), so deleting a page in the CMS emptied a
     * panel on the front page. Here it is simply the section's own order.
     *
     * @return array<int,array<string,mixed>>
     */
    public function featured(string $section, string $locale, string $fallback, int $limit): array
    {
        return $this->db()->select(
            'SELECT p.id, p.section, p.slug,
                    COALESCE(t.title, f.title)       AS title,
                    COALESCE(t.subtitle, f.subtitle) AS subtitle,
                    COALESCE(t.body, f.body)         AS body,
                    COALESCE(t.slug, p.slug)         AS locale_slug,
                    c.path AS cover_path, c.alt AS cover_alt
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
          LEFT JOIN page_translations f ON f.page_id = p.id AND f.locale = ?
          LEFT JOIN media c ON c.id = p.cover_media_id
              WHERE p.section = ? AND p.parent_id IS NULL AND ' . $this->publishedClause() . '
           ORDER BY p.sort, p.id
              LIMIT ?',
            [$locale, $fallback, $section, $limit]
        );
    }

    /**
     * Whole-site navigation: every published page, grouped by section, for the
     * header menu. Replaces the DB-driven header_menu() of the legacy site.
     *
     * @return array<string,array<int,array<string,mixed>>> section => rows
     */
    public function navigation(string $locale, string $fallback): array
    {
        $rows = $this->db()->select(
            'SELECT p.id, p.section, p.parent_id, p.slug, p.sort,
                    COALESCE(t.title, f.title) AS title,
                    COALESCE(t.slug, p.slug)   AS locale_slug
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
          LEFT JOIN page_translations f ON f.page_id = p.id AND f.locale = ?
              WHERE ' . $this->publishedClause() . '
           ORDER BY p.section, p.sort, p.id',
            [$locale, $fallback]
        );

        $bySection = [];
        foreach ($rows as $row) {
            $bySection[(string) $row['section']][] = $row;
        }

        return $bySection;
    }

    /* ---- admin ----------------------------------------------------------- */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function adminPage(string $defaultLocale, int $limit, int $offset, string $section = '', string $status = ''): array
    {
        $where    = ['1 = 1'];
        $bindings = [$defaultLocale];

        if ($section !== '') {
            $where[]    = 'p.section = ?';
            $bindings[] = $section;
        }

        if ($status !== '') {
            $where[]    = 'p.status = ?';
            $bindings[] = $status;
        }

        $bindings[] = $limit;
        $bindings[] = $offset;

        return $this->db()->select(
            'SELECT p.id, p.section, p.parent_id, p.type, p.slug, p.status, p.sort, p.updated_at,
                    t.title AS title,
                    pt.title AS parent_title
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
          LEFT JOIN pages parent ON parent.id = p.parent_id
          LEFT JOIN page_translations pt ON pt.page_id = parent.id AND pt.locale = t.locale
              WHERE ' . implode(' AND ', $where) . '
           ORDER BY p.section, COALESCE(p.parent_id, p.id), p.parent_id IS NOT NULL, p.sort, p.id
              LIMIT ? OFFSET ?',
            $bindings
        );
    }

    public function adminCount(string $section = '', string $status = ''): int
    {
        $where    = ['1 = 1'];
        $bindings = [];

        if ($section !== '') {
            $where[]    = 'section = ?';
            $bindings[] = $section;
        }

        if ($status !== '') {
            $where[]    = 'status = ?';
            $bindings[] = $status;
        }

        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM pages WHERE ' . implode(' AND ', $where),
            $bindings
        );
    }

    /**
     * Candidate parents for the editor's parent selector: top-level pages in
     * the same section, excluding the page being edited.
     *
     * @return array<int,array<string,mixed>>
     */
    public function parentOptions(string $section, string $locale, int $excludeId = 0): array
    {
        return $this->db()->select(
            'SELECT p.id, COALESCE(t.title, p.slug) AS title
               FROM pages p
          LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = ?
              WHERE p.section = ? AND p.parent_id IS NULL AND p.id <> ?
           ORDER BY p.sort, p.id',
            [$locale, $section, $excludeId]
        );
    }

    /**
     * @return array<string,array<string,mixed>> keyed by locale
     */
    public function translations(int $pageId): array
    {
        $rows  = $this->db()->select('SELECT * FROM page_translations WHERE page_id = ?', [$pageId]);
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
        return $this->db()->selectOne('SELECT * FROM pages WHERE legacy_ref = ? LIMIT 1', [$ref]);
    }

    public function uniqueSlug(string $section, string $slug, int $ignoreId = 0): string
    {
        $slug = $slug === '' ? 'halaman' : $slug;
        $base = $slug;
        $n    = 2;

        while (true) {
            $exists = $this->db()->scalar(
                'SELECT id FROM pages WHERE section = ? AND slug = ? AND id <> ? LIMIT 1',
                [$section, $slug, $ignoreId]
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
    public function createWithTranslations(array $page, array $translations): int
    {
        return $this->db()->transaction(function () use ($page, $translations) {
            $page['created_at'] = date('Y-m-d H:i:s');
            $page['updated_at'] = $page['created_at'];

            $id = $this->insert($page);
            $this->saveTranslations($id, $translations);

            return $id;
        });
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    public function updateWithTranslations(int $id, array $page, array $translations): void
    {
        $this->db()->transaction(function () use ($id, $page, $translations) {
            $page['updated_at'] = date('Y-m-d H:i:s');

            $this->update($id, $page);
            $this->saveTranslations($id, $translations);
        });
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    private function saveTranslations(int $pageId, array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            $this->db()->run(
                'INSERT INTO page_translations
                    (page_id, locale, slug, title, subtitle, body, meta_title, meta_description)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    slug = VALUES(slug), title = VALUES(title), subtitle = VALUES(subtitle),
                    body = VALUES(body), meta_title = VALUES(meta_title),
                    meta_description = VALUES(meta_description)',
                [
                    $pageId,
                    $locale,
                    isset($fields['slug']) && $fields['slug'] !== '' ? $fields['slug'] : null,
                    isset($fields['title']) ? $fields['title'] : '',
                    isset($fields['subtitle']) ? $fields['subtitle'] : null,
                    isset($fields['body']) ? $fields['body'] : null,
                    isset($fields['meta_title']) ? $fields['meta_title'] : null,
                    isset($fields['meta_description']) ? $fields['meta_description'] : null,
                ]
            );
        }
    }
}
