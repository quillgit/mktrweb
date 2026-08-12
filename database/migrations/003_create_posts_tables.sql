-- News.
--
-- Two structural changes from the legacy tabel_berita:
--   1. Translatable text moves to post_translations, one row per locale,
--      replacing the paired title/title_english, content/content_english
--      columns. Adding a third language becomes data, not a schema change.
--   2. status is a real workflow state (draft/scheduled/published) instead of
--      the legacy magic value '2'.

CREATE TABLE IF NOT EXISTS post_categories (
    id   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug VARCHAR(120) NOT NULL,
    sort SMALLINT     NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_post_categories_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS post_category_translations (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id INT UNSIGNED NOT NULL,
    locale      VARCHAR(5)   NOT NULL,
    name        VARCHAR(160) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_post_category_locale (category_id, locale),
    KEY idx_pct_locale (locale),
    CONSTRAINT fk_pct_category FOREIGN KEY (category_id) REFERENCES post_categories (id) ON DELETE CASCADE,
    CONSTRAINT fk_pct_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id    INT UNSIGNED NULL DEFAULT NULL,
    cover_media_id INT UNSIGNED NULL DEFAULT NULL,
    slug           VARCHAR(191) NOT NULL,
    status         ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
    -- For scheduled posts this is the future go-live time; the front-end
    -- filters on status = 'published' AND published_at <= NOW().
    published_at   DATETIME     NULL DEFAULT NULL,
    author_id      INT UNSIGNED NULL DEFAULT NULL,
    views          INT UNSIGNED NOT NULL DEFAULT 0,
    created_at     DATETIME     NOT NULL,
    updated_at     DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_posts_slug (slug),
    KEY idx_posts_listing (status, published_at),
    KEY idx_posts_category (category_id),
    KEY idx_posts_author (author_id),
    CONSTRAINT fk_posts_category FOREIGN KEY (category_id) REFERENCES post_categories (id) ON DELETE SET NULL,
    CONSTRAINT fk_posts_cover FOREIGN KEY (cover_media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_posts_author FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS post_translations (
    id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    post_id          INT UNSIGNED NOT NULL,
    locale           VARCHAR(5)   NOT NULL,
    title            VARCHAR(255) NOT NULL,
    excerpt          TEXT         NULL,
    -- Sanitised on save by Mktr\Core\Html::sanitize().
    body             LONGTEXT     NULL,
    meta_title       VARCHAR(255) NULL,
    meta_description VARCHAR(500) NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_post_locale (post_id, locale),
    KEY idx_post_translations_locale (locale),
    CONSTRAINT fk_pt_post FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE,
    CONSTRAINT fk_pt_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO post_categories (id, slug, sort) VALUES (1, 'berita', 1);
INSERT IGNORE INTO post_categories (id, slug, sort) VALUES (2, 'kegiatan', 2);

INSERT IGNORE INTO post_category_translations (category_id, locale, name) VALUES (1, 'id', 'Berita');
INSERT IGNORE INTO post_category_translations (category_id, locale, name) VALUES (1, 'en', 'News');
INSERT IGNORE INTO post_category_translations (category_id, locale, name) VALUES (2, 'id', 'Kegiatan');
INSERT IGNORE INTO post_category_translations (category_id, locale, name) VALUES (2, 'en', 'Events');
