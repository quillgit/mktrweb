<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class Post extends Model
{
    /** @var string */
    protected $table = 'posts';

    /** @var string[] */
    protected $sortable = ['id', 'slug', 'status', 'published_at', 'created_at', 'views'];

    /**
     * A post is visible only when it is published AND its go-live time has
     * passed, which is what makes scheduling work without a cron job.
     */
    private function publishedClause(): string
    {
        return "p.status = 'published' AND p.published_at IS NOT NULL AND p.published_at <= NOW()";
    }

    /**
     * Published posts for the front-end listing, joined to the requested locale
     * with a fallback to the default so a half-translated post still renders.
     *
     * @return array<int,array<string,mixed>>
     */
    public function publishedPage(string $locale, string $fallback, int $limit, int $offset): array
    {
        return $this->db()->select(
            'SELECT p.id, p.slug, p.published_at, p.views,
                    COALESCE(t.title, f.title)     AS title,
                    COALESCE(t.excerpt, f.excerpt) AS excerpt,
                    m.path  AS cover_path,
                    m.alt   AS cover_alt,
                    m.width AS cover_width,
                    m.height AS cover_height
               FROM posts p
          LEFT JOIN post_translations t ON t.post_id = p.id AND t.locale = ?
          LEFT JOIN post_translations f ON f.post_id = p.id AND f.locale = ?
          LEFT JOIN media m ON m.id = p.cover_media_id
              WHERE ' . $this->publishedClause() . '
           ORDER BY p.published_at DESC, p.id DESC
              LIMIT ? OFFSET ?',
            [$locale, $fallback, $limit, $offset]
        );
    }

    public function countPublished(): int
    {
        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM posts p WHERE ' . $this->publishedClause()
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findPublished(int $id, string $locale, string $fallback): ?array
    {
        return $this->db()->selectOne(
            'SELECT p.id, p.slug, p.published_at, p.views, p.category_id,
                    COALESCE(t.title, f.title)     AS title,
                    COALESCE(t.excerpt, f.excerpt) AS excerpt,
                    COALESCE(t.body, f.body)       AS body,
                    COALESCE(t.meta_title, f.meta_title)             AS meta_title,
                    COALESCE(t.meta_description, f.meta_description) AS meta_description,
                    m.path AS cover_path, m.alt AS cover_alt,
                    m.width AS cover_width, m.height AS cover_height
               FROM posts p
          LEFT JOIN post_translations t ON t.post_id = p.id AND t.locale = ?
          LEFT JOIN post_translations f ON f.post_id = p.id AND f.locale = ?
          LEFT JOIN media m ON m.id = p.cover_media_id
              WHERE p.id = ? AND ' . $this->publishedClause() . '
              LIMIT 1',
            [$locale, $fallback, $id]
        );
    }

    /**
     * Latest published posts excluding one id — used for "related" blocks.
     *
     * @return array<int,array<string,mixed>>
     */
    public function latestExcept(int $excludeId, string $locale, string $fallback, int $limit): array
    {
        return $this->db()->select(
            'SELECT p.id, p.slug, p.published_at,
                    COALESCE(t.title, f.title) AS title,
                    m.path AS cover_path, m.alt AS cover_alt
               FROM posts p
          LEFT JOIN post_translations t ON t.post_id = p.id AND t.locale = ?
          LEFT JOIN post_translations f ON f.post_id = p.id AND f.locale = ?
          LEFT JOIN media m ON m.id = p.cover_media_id
              WHERE p.id <> ? AND ' . $this->publishedClause() . '
           ORDER BY p.published_at DESC
              LIMIT ?',
            [$locale, $fallback, $excludeId, $limit]
        );
    }

    public function incrementViews(int $id): void
    {
        $this->db()->affected('UPDATE posts SET views = views + 1 WHERE id = ?', [$id]);
    }

    /* ---- admin ----------------------------------------------------------- */

    /**
     * Admin listing — every status, default-locale title for the table.
     *
     * @return array<int,array<string,mixed>>
     */
    public function adminPage(string $defaultLocale, int $limit, int $offset, string $status = ''): array
    {
        $where    = '1 = 1';
        $bindings = [$defaultLocale];

        if ($status !== '') {
            $where      = 'p.status = ?';
            $bindings[] = $status;
        }

        $bindings[] = $limit;
        $bindings[] = $offset;

        return $this->db()->select(
            'SELECT p.id, p.slug, p.status, p.published_at, p.updated_at, p.views,
                    t.title AS title,
                    u.name  AS author_name,
                    m.path  AS cover_path
               FROM posts p
          LEFT JOIN post_translations t ON t.post_id = p.id AND t.locale = ?
          LEFT JOIN users u ON u.id = p.author_id
          LEFT JOIN media m ON m.id = p.cover_media_id
              WHERE ' . $where . '
           ORDER BY p.updated_at DESC, p.id DESC
              LIMIT ? OFFSET ?',
            $bindings
        );
    }

    public function adminCount(string $status = ''): int
    {
        if ($status === '') {
            return $this->count();
        }

        return (int) $this->db()->scalar('SELECT COUNT(*) FROM posts WHERE status = ?', [$status]);
    }

    /**
     * @return array<int,array<string,mixed>> keyed by locale
     */
    public function translations(int $postId): array
    {
        $rows   = $this->db()->select('SELECT * FROM post_translations WHERE post_id = ?', [$postId]);
        $keyed  = [];

        foreach ($rows as $row) {
            $keyed[(string) $row['locale']] = $row;
        }

        return $keyed;
    }

    /**
     * Ensure a slug is unique, ignoring the record being edited.
     */
    public function uniqueSlug(string $slug, int $ignoreId = 0): string
    {
        $slug = $slug === '' ? 'post' : $slug;
        $base = $slug;
        $n    = 2;

        while (true) {
            $exists = $this->db()->scalar(
                'SELECT id FROM posts WHERE slug = ? AND id <> ? LIMIT 1',
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
     * @param array<string,array<string,string>> $translations locale => fields
     */
    public function createWithTranslations(array $post, array $translations): int
    {
        return $this->db()->transaction(function () use ($post, $translations) {
            $post['created_at'] = date('Y-m-d H:i:s');
            $post['updated_at'] = $post['created_at'];

            $postId = $this->insert($post);

            $this->saveTranslations($postId, $translations);

            return $postId;
        });
    }

    /**
     * @param array<string,array<string,string>> $translations locale => fields
     */
    public function updateWithTranslations(int $postId, array $post, array $translations): void
    {
        $this->db()->transaction(function () use ($postId, $post, $translations) {
            $post['updated_at'] = date('Y-m-d H:i:s');

            $this->update($postId, $post);
            $this->saveTranslations($postId, $translations);
        });
    }

    /**
     * @param array<string,array<string,string>> $translations
     */
    private function saveTranslations(int $postId, array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            $this->db()->run(
                'INSERT INTO post_translations
                    (post_id, locale, title, excerpt, body, meta_title, meta_description)
                 VALUES (?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    title = VALUES(title),
                    excerpt = VALUES(excerpt),
                    body = VALUES(body),
                    meta_title = VALUES(meta_title),
                    meta_description = VALUES(meta_description)',
                [
                    $postId,
                    $locale,
                    isset($fields['title']) ? $fields['title'] : '',
                    isset($fields['excerpt']) ? $fields['excerpt'] : null,
                    isset($fields['body']) ? $fields['body'] : null,
                    isset($fields['meta_title']) ? $fields['meta_title'] : null,
                    isset($fields['meta_description']) ? $fields['meta_description'] : null,
                ]
            );
        }
    }
}
