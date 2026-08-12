<?php

namespace Mktr\Models;

use Mktr\Core\Model;

/**
 * Small content collections — leadership, subsidiaries, awards, memberships,
 * milestones and home banners — sharing one table discriminated by `kind`.
 */
class CollectionItem extends Model
{
    /** @var string */
    protected $table = 'collection_items';

    /** @var string[] */
    protected $sortable = ['id', 'kind', 'sort', 'status', 'created_at'];

    /** @var string[] */
    public static $kinds = ['leadership', 'subsidiary', 'award', 'membership', 'milestone', 'banner'];

    /**
     * @return array<int,array<string,mixed>>
     */
    public function published(string $kind, string $locale, string $fallback, ?string $group = null): array
    {
        $bindings = [$locale, $fallback, $kind];
        $groupSql = '';

        if ($group !== null) {
            $groupSql   = ' AND c.group_key = ?';
            $bindings[] = $group;
        }

        return $this->db()->select(
            "SELECT c.id, c.kind, c.group_key, c.slug, c.link, c.sort,
                    COALESCE(t.title, f.title)       AS title,
                    COALESCE(t.subtitle, f.subtitle) AS subtitle,
                    COALESCE(t.body, f.body)         AS body,
                    m.path  AS image_path,  m.alt AS image_alt,
                    d.path  AS detail_path,
                    mo.path AS mobile_path
               FROM collection_items c
          LEFT JOIN collection_item_translations t ON t.item_id = c.id AND t.locale = ?
          LEFT JOIN collection_item_translations f ON f.item_id = c.id AND f.locale = ?
          LEFT JOIN media m  ON m.id  = c.image_media_id
          LEFT JOIN media d  ON d.id  = c.detail_image_media_id
          LEFT JOIN media mo ON mo.id = c.mobile_image_media_id
              WHERE c.kind = ? AND c.status = 'published'" . $groupSql . '
           ORDER BY c.sort ASC, c.id ASC',
            $bindings
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findPublishedBySlug(string $kind, string $slug, string $locale, string $fallback): ?array
    {
        return $this->db()->selectOne(
            "SELECT c.id, c.kind, c.group_key, c.slug, c.link,
                    COALESCE(t.title, f.title)       AS title,
                    COALESCE(t.subtitle, f.subtitle) AS subtitle,
                    COALESCE(t.body, f.body)         AS body,
                    m.path AS image_path, d.path AS detail_path
               FROM collection_items c
          LEFT JOIN collection_item_translations t ON t.item_id = c.id AND t.locale = ?
          LEFT JOIN collection_item_translations f ON f.item_id = c.id AND f.locale = ?
          LEFT JOIN media m ON m.id = c.image_media_id
          LEFT JOIN media d ON d.id = c.detail_image_media_id
              WHERE c.kind = ? AND c.slug = ? AND c.status = 'published'
              LIMIT 1",
            [$locale, $fallback, $kind, $slug]
        );
    }

    /* ---- admin ----------------------------------------------------------- */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function adminPage(string $defaultLocale, int $limit, int $offset, string $kind = ''): array
    {
        $where    = ['1 = 1'];
        $bindings = [$defaultLocale];

        if ($kind !== '') {
            $where[]    = 'c.kind = ?';
            $bindings[] = $kind;
        }

        $bindings[] = $limit;
        $bindings[] = $offset;

        return $this->db()->select(
            'SELECT c.id, c.kind, c.group_key, c.slug, c.sort, c.status, c.updated_at,
                    t.title AS title, m.path AS image_path
               FROM collection_items c
          LEFT JOIN collection_item_translations t ON t.item_id = c.id AND t.locale = ?
          LEFT JOIN media m ON m.id = c.image_media_id
              WHERE ' . implode(' AND ', $where) . '
           ORDER BY c.kind, c.sort, c.id
              LIMIT ? OFFSET ?',
            $bindings
        );
    }

    public function adminCount(string $kind = ''): int
    {
        if ($kind === '') {
            return $this->count();
        }

        return (int) $this->db()->scalar('SELECT COUNT(*) FROM collection_items WHERE kind = ?', [$kind]);
    }

    /**
     * @return array<string,array<string,mixed>> keyed by locale
     */
    public function translations(int $itemId): array
    {
        $rows  = $this->db()->select('SELECT * FROM collection_item_translations WHERE item_id = ?', [$itemId]);
        $keyed = [];

        foreach ($rows as $row) {
            $keyed[(string) $row['locale']] = $row;
        }

        return $keyed;
    }

    public function uniqueSlug(string $kind, string $slug, int $ignoreId = 0): string
    {
        $slug = $slug === '' ? 'item' : $slug;
        $base = $slug;
        $n    = 2;

        while (true) {
            $exists = $this->db()->scalar(
                'SELECT id FROM collection_items WHERE kind = ? AND slug = ? AND id <> ? LIMIT 1',
                [$kind, $slug, $ignoreId]
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
    public function createWithTranslations(array $item, array $translations): int
    {
        return $this->db()->transaction(function () use ($item, $translations) {
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = $item['created_at'];

            $id = $this->insert($item);
            $this->saveTranslations($id, $translations);

            return $id;
        });
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    public function updateWithTranslations(int $id, array $item, array $translations): void
    {
        $this->db()->transaction(function () use ($id, $item, $translations) {
            $item['updated_at'] = date('Y-m-d H:i:s');

            $this->update($id, $item);
            $this->saveTranslations($id, $translations);
        });
    }

    /**
     * @param array<string,array<string,mixed>> $translations
     */
    private function saveTranslations(int $itemId, array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            $this->db()->run(
                'INSERT INTO collection_item_translations (item_id, locale, title, subtitle, body)
                 VALUES (?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE title = VALUES(title), subtitle = VALUES(subtitle), body = VALUES(body)',
                [
                    $itemId,
                    $locale,
                    isset($fields['title']) ? $fields['title'] : '',
                    isset($fields['subtitle']) ? $fields['subtitle'] : null,
                    isset($fields['body']) ? $fields['body'] : null,
                ]
            );
        }
    }
}
