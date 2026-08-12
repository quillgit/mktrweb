-- The media library now holds PDFs as well as images, so it needs to say which
-- is which: the picker filters on it, and the library renders a file card
-- rather than a broken <img> for documents.
ALTER TABLE media
    ADD COLUMN kind ENUM('image','document') NOT NULL DEFAULT 'image' AFTER mime,
    ADD KEY idx_media_kind (kind);

-- Existing rows predate the column and are all images; the default already
-- covers them, but be explicit rather than relying on it.
UPDATE media SET kind = 'image' WHERE mime LIKE 'image/%';
UPDATE media SET kind = 'document' WHERE mime = 'application/pdf';

-- Same idempotency anchor the documents table uses, so tabel_berita can be
-- re-imported without creating duplicates.
ALTER TABLE posts
    ADD COLUMN legacy_ref VARCHAR(120) NULL DEFAULT NULL AFTER views,
    ADD UNIQUE KEY uniq_posts_legacy_ref (legacy_ref);

-- Media rows created by the importer point at pre-existing files under
-- images/ and dokumen/ rather than storage/uploads, so they must never be
-- deleted from disk when the row is removed.
ALTER TABLE media
    ADD COLUMN is_external TINYINT(1) NOT NULL DEFAULT 0 AFTER folder;
