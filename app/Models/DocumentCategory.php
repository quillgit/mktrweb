<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class DocumentCategory extends Model
{
    /** @var string */
    protected $table = 'document_categories';

    /** @var string[] */
    protected $sortable = ['id', 'slug', 'sort'];

    /**
     * Every active category with the requested locale's name, falling back to
     * the default locale when a translation is missing. Used for the tab strip
     * and the admin category selector.
     *
     * @return array<int,array<string,mixed>>
     */
    public function listing(string $locale, string $fallback): array
    {
        return $this->db()->select(
            'SELECT c.id, c.slug, c.layout, c.sort,
                    COALESCE(t.name, f.name) AS name,
                    COALESCE(t.description, f.description) AS description
               FROM document_categories c
          LEFT JOIN document_category_translations t ON t.category_id = c.id AND t.locale = ?
          LEFT JOIN document_category_translations f ON f.category_id = c.id AND f.locale = ?
              WHERE c.status = 1
           ORDER BY c.sort ASC, c.id ASC',
            [$locale, $fallback]
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findBySlug(string $slug, string $locale, string $fallback): ?array
    {
        return $this->db()->selectOne(
            'SELECT c.id, c.slug, c.layout,
                    COALESCE(t.name, f.name) AS name,
                    COALESCE(t.description, f.description) AS description
               FROM document_categories c
          LEFT JOIN document_category_translations t ON t.category_id = c.id AND t.locale = ?
          LEFT JOIN document_category_translations f ON f.category_id = c.id AND f.locale = ?
              WHERE c.slug = ? AND c.status = 1
              LIMIT 1',
            [$locale, $fallback, $slug]
        );
    }

    /**
     * Slug -> id map, used by the importer to place legacy rows.
     *
     * @return array<string,int>
     */
    public function slugMap(): array
    {
        $rows = $this->db()->select('SELECT id, slug FROM document_categories');
        $map  = [];

        foreach ($rows as $row) {
            $map[(string) $row['slug']] = (int) $row['id'];
        }

        return $map;
    }
}
