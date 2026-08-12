-- Content pages.
--
-- One table absorbs six legacy tables (100 rows in production):
--
--   tabel_about_us              7   -> section 'about'      (flat)
--   tabel_bisnis_inti           4   -> section 'business'   (flat)
--   tabel_berkelanjutan        45   -> section 'sustainability'
--   tabel_tatakelola_perusahaan 22  -> section 'governance'
--   tabel_tentang_kami         13   -> section 'investor'
--   tabel_sumber_daya           9   -> section 'hr'
--
-- The four hierarchical tables carry `kategori` ∈ {parent, child, single} and
-- `child` holding the parent id. That collapses to parent_id: NULL means top
-- level, so 'parent' and 'single' are the same thing and the distinction
-- (whether children exist) is derived rather than stored.
--
-- They also carry `tipe` ∈ {text, dokumen}: some pages are prose, others are
-- document listings. That becomes `type`, with document_category_id saying
-- which listing. `grievances` is the third type — the public RSPO grievance
-- register at /keberlanjutan/daftar-pengaduan.

CREATE TABLE IF NOT EXISTS pages (
    id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    section              ENUM('about','business','sustainability','governance','investor','hr') NOT NULL,
    parent_id            INT UNSIGNED NULL DEFAULT NULL,
    type                 ENUM('text','documents','grievances') NOT NULL DEFAULT 'text',
    -- Canonical slug (default locale). page_translations.slug overrides it
    -- per locale, because the legacy tables carry slug and slug_english.
    slug                 VARCHAR(191) NOT NULL,
    document_category_id INT UNSIGNED NULL DEFAULT NULL,
    cover_media_id       INT UNSIGNED NULL DEFAULT NULL,
    banner_media_id      INT UNSIGNED NULL DEFAULT NULL,
    banner_mobile_media_id INT UNSIGNED NULL DEFAULT NULL,
    sort                 SMALLINT     NOT NULL DEFAULT 0,
    status               ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
    published_at         DATETIME     NULL DEFAULT NULL,
    legacy_ref           VARCHAR(120) NULL DEFAULT NULL,
    created_at           DATETIME     NOT NULL,
    updated_at           DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_pages_section_slug (section, slug),
    UNIQUE KEY uniq_pages_legacy_ref (legacy_ref),
    KEY idx_pages_listing (section, status, sort),
    KEY idx_pages_parent (parent_id),
    KEY idx_pages_category (document_category_id),
    CONSTRAINT fk_pages_parent FOREIGN KEY (parent_id) REFERENCES pages (id) ON DELETE SET NULL,
    CONSTRAINT fk_pages_category FOREIGN KEY (document_category_id) REFERENCES document_categories (id) ON DELETE SET NULL,
    CONSTRAINT fk_pages_cover FOREIGN KEY (cover_media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_pages_banner FOREIGN KEY (banner_media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_pages_banner_mobile FOREIGN KEY (banner_mobile_media_id) REFERENCES media (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS page_translations (
    id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    page_id          INT UNSIGNED NOT NULL,
    locale           VARCHAR(5)   NOT NULL,
    -- Locale-specific slug; falls back to pages.slug when null.
    slug             VARCHAR(191) NULL DEFAULT NULL,
    title            VARCHAR(255) NOT NULL,
    subtitle         VARCHAR(255) NULL DEFAULT NULL,
    body             LONGTEXT     NULL,
    meta_title       VARCHAR(255) NULL DEFAULT NULL,
    meta_description VARCHAR(500) NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_page_locale (page_id, locale),
    KEY idx_page_translations_slug (locale, slug),
    CONSTRAINT fk_pgt_page FOREIGN KEY (page_id) REFERENCES pages (id) ON DELETE CASCADE,
    CONSTRAINT fk_pgt_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
