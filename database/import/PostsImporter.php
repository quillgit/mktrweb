<?php
/**
 * tabel_berita -> posts + post_translations.
 */

namespace Mktr\Import;

class PostsImporter extends Importer
{
    const TABLE = 'tabel_berita';

    public function name(): string
    {
        return 'posts';
    }

    public function run(): void
    {
        if (!$this->tableExists(self::TABLE)) {
            $this->note(self::TABLE . ': table not present in the legacy database, skipped');
            return;
        }

        $primary   = $this->firstColumn(self::TABLE, ['id_berita', 'id']);
        $dateCol   = $this->firstColumn(self::TABLE, ['created', 'tanggal', 'date']);
        $titleEn   = $this->hasColumn(self::TABLE, 'title_english') ? 'title_english' : null;
        $contentEn = $this->hasColumn(self::TABLE, 'content_english') ? 'content_english' : null;
        $statusCol = $this->hasColumn(self::TABLE, 'status') ? 'status' : null;

        if ($primary === null) {
            $this->note(self::TABLE . ': no recognisable primary key, skipped');
            return;
        }

        $rows = $this->fetchAll('SELECT * FROM ' . self::TABLE);
        $this->count(self::TABLE, 'source', count($rows));

        foreach ($rows as $row) {
            $sourceId = isset($row[$primary]) ? (int) $row[$primary] : 0;
            $title    = isset($row['title']) ? trim((string) $row['title']) : '';

            if ($sourceId === 0 || $title === '') {
                $this->count(self::TABLE, 'skipped');
                continue;
            }

            $ref     = self::TABLE . ':' . $sourceId;
            $coverId = $this->registerFile(
                isset($row['gambar']) ? (string) $row['gambar'] : null,
                'images/post',
                'image',
                self::TABLE
            );

            $created = $this->normaliseDate($dateCol !== null && isset($row[$dateCol]) ? $row[$dateCol] : null);
            $status  = $statusCol !== null ? $this->mapStatus($row[$statusCol]) : 'draft';

            // Legacy slugs are not reliably unique; fall back to the title and
            // let the model disambiguate.
            $slug = isset($row['slug']) && trim((string) $row['slug']) !== ''
                ? str_slug((string) $row['slug'])
                : str_slug($title);

            if ($this->dryRun) {
                $this->count(self::TABLE, 'imported');
                continue;
            }

            $existing = $this->db->selectOne('SELECT id FROM posts WHERE legacy_ref = ? LIMIT 1', [$ref]);

            $body   = isset($row['content']) ? \Mktr\Core\Html::sanitize((string) $row['content']) : '';
            $bodyEn = $contentEn !== null && isset($row[$contentEn])
                ? \Mktr\Core\Html::sanitize((string) $row[$contentEn])
                : $body;

            if ($existing === null) {
                $posts = new \Mktr\Models\Post();

                $postId = $this->db->insert(
                    'INSERT INTO posts (category_id, cover_media_id, slug, status, published_at, views, legacy_ref, created_at, updated_at)
                     VALUES (1, ?, ?, ?, ?, 0, ?, ?, ?)',
                    [
                        $coverId,
                        $posts->uniqueSlug($slug),
                        $status,
                        $status === 'published' ? ($created !== null ? $created : date('Y-m-d H:i:s')) : null,
                        $ref,
                        $created !== null ? $created : date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );

                $this->count(self::TABLE, 'imported');
            } else {
                $postId = (int) $existing['id'];

                $this->db->affected(
                    'UPDATE posts SET cover_media_id = ?, status = ?, published_at = ?, updated_at = ? WHERE id = ?',
                    [
                        $coverId,
                        $status,
                        $status === 'published' ? ($created !== null ? $created : date('Y-m-d H:i:s')) : null,
                        date('Y-m-d H:i:s'),
                        $postId,
                    ]
                );

                $this->count(self::TABLE, 'updated');
            }

            $translations = [
                'id' => ['title' => $title, 'body' => $body],
                'en' => [
                    'title' => $titleEn !== null && trim((string) $row[$titleEn]) !== '' ? (string) $row[$titleEn] : $title,
                    'body'  => $bodyEn,
                ],
            ];

            foreach ($translations as $locale => $fields) {
                $this->db->run(
                    'INSERT INTO post_translations (post_id, locale, title, excerpt, body)
                     VALUES (?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE title = VALUES(title), excerpt = VALUES(excerpt), body = VALUES(body)',
                    [
                        $postId,
                        $locale,
                        $fields['title'],
                        \Mktr\Core\Html::excerpt($fields['body']),
                        $fields['body'],
                    ]
                );
            }
        }
    }
}
