-- Collections and inquiries — the last of the legacy content tables.
--
-- COLLECTIONS
-- Six legacy tables are the same shape: a small list of things with an image,
-- a title, some body text and an optional link. Rather than six more tables
-- they share one, discriminated by `kind`:
--
--   tabel_struktur_organisasi  9  -> leadership  (group_key = dewan_komisaris | dewan_direksi)
--   tabel_perusahaan           4  -> subsidiary
--   tabel_penghargaan          4  -> award
--   tabel_keanggotaan          3  -> membership
--   tabel_jejak_perusahaan    12  -> milestone   (title is the year)
--   tabel_banner               2  -> banner      (home hero)
--
-- INQUIRIES
-- Three public forms plus one legacy inbox land in one table. The shared
-- fields are columns; everything form-specific goes in `payload` so a new form
-- does not need a migration. Submissions are never public.

CREATE TABLE IF NOT EXISTS collection_items (
    id                     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    kind                   ENUM('leadership','subsidiary','award','membership','milestone','banner') NOT NULL,
    -- Sub-grouping within a kind; only leadership uses it today.
    group_key              VARCHAR(60)  NULL DEFAULT NULL,
    slug                   VARCHAR(191) NULL DEFAULT NULL,
    image_media_id         INT UNSIGNED NULL DEFAULT NULL,
    -- Portrait/large variant, used by the leadership detail page.
    detail_image_media_id  INT UNSIGNED NULL DEFAULT NULL,
    mobile_image_media_id  INT UNSIGNED NULL DEFAULT NULL,
    link                   VARCHAR(500) NULL DEFAULT NULL,
    sort                   SMALLINT     NOT NULL DEFAULT 0,
    status                 ENUM('draft','published') NOT NULL DEFAULT 'draft',
    published_at           DATETIME     NULL DEFAULT NULL,
    legacy_ref             VARCHAR(120) NULL DEFAULT NULL,
    created_at             DATETIME     NOT NULL,
    updated_at             DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_collection_legacy_ref (legacy_ref),
    UNIQUE KEY uniq_collection_kind_slug (kind, slug),
    KEY idx_collection_listing (kind, status, sort),
    KEY idx_collection_group (kind, group_key, sort),
    CONSTRAINT fk_ci_image FOREIGN KEY (image_media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_ci_detail FOREIGN KEY (detail_image_media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_ci_mobile FOREIGN KEY (mobile_image_media_id) REFERENCES media (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS collection_item_translations (
    id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    item_id  INT UNSIGNED NOT NULL,
    locale   VARCHAR(5)   NOT NULL,
    title    VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL DEFAULT NULL,
    body     LONGTEXT     NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_cit_item_locale (item_id, locale),
    CONSTRAINT fk_cit_item FOREIGN KEY (item_id) REFERENCES collection_items (id) ON DELETE CASCADE,
    CONSTRAINT fk_cit_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS inquiries (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    kind       ENUM('contact','grievance','whistleblower') NOT NULL,
    name       VARCHAR(191) NULL DEFAULT NULL,
    email      VARCHAR(191) NULL DEFAULT NULL,
    phone      VARCHAR(40)  NULL DEFAULT NULL,
    subject    VARCHAR(255) NULL DEFAULT NULL,
    message    LONGTEXT     NULL,
    -- Form-specific fields as JSON, so adding a form needs no migration.
    payload    LONGTEXT     NULL,
    status     ENUM('new','read','archived') NOT NULL DEFAULT 'new',
    ip         VARCHAR(45)  NULL DEFAULT NULL,
    user_agent VARCHAR(255) NULL DEFAULT NULL,
    legacy_ref VARCHAR(120) NULL DEFAULT NULL,
    created_at DATETIME     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_inquiries_legacy_ref (legacy_ref),
    KEY idx_inquiries_listing (kind, status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
