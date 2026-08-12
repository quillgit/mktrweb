-- Corrections found by loading the production dump.
--
-- 1. tabel_laporan_ispo exists in production (ISPO certification) and was
--    missing from the seeded categories and the importer map.
--
-- 2. `laporan-keluhan` was seeded as a document category on the assumption
--    that tabel_laporan_keluhan held reports. It does not: its columns are
--    name, organization, address, email, phone, communication, status_laporan
--    and it has NO file column at all. Those are grievance submissions.
--    Importing them as documents would have published complainants' contact
--    details in a public download list.
--
-- 3. tabel_laporan_iscc has no table of its own; the sustainability section
--    has an `iscc` document page, so it gets a category to land in.

INSERT IGNORE INTO document_categories (slug, layout, sort) VALUES
    ('ispo', 'cover-grid', 20),
    ('iscc', 'list', 21);

INSERT IGNORE INTO document_category_translations (category_id, locale, name)
SELECT id, 'id', 'ISPO' FROM document_categories WHERE slug = 'ispo';
INSERT IGNORE INTO document_category_translations (category_id, locale, name)
SELECT id, 'en', 'ISPO' FROM document_categories WHERE slug = 'ispo';
INSERT IGNORE INTO document_category_translations (category_id, locale, name)
SELECT id, 'id', 'ISCC' FROM document_categories WHERE slug = 'iscc';
INSERT IGNORE INTO document_category_translations (category_id, locale, name)
SELECT id, 'en', 'ISCC' FROM document_categories WHERE slug = 'iscc';

-- Remove the mistaken category. Cascades clear its translations; there should
-- be no documents in it, and the delete would fail loudly if there were.
DELETE FROM document_categories WHERE slug = 'laporan-keluhan';

-- The grievance register that daftar-pengaduan actually renders.
--
-- The legacy page publishes only laporan_date, communication, organization,
-- name and status (module/keberlanjutan.php:545), filtered to status = '2' AND
-- status_laporan <> 'laporan'. email, phone and address are stored but never
-- rendered publicly, so they live here and are exposed to the admin only.
CREATE TABLE IF NOT EXISTS grievances (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    reported_on     DATE         NULL DEFAULT NULL,
    reporter_name   VARCHAR(150) NULL DEFAULT NULL,
    organization    VARCHAR(150) NULL DEFAULT NULL,
    communication   VARCHAR(255) NULL DEFAULT NULL,
    -- Private: never rendered on the public register.
    email           VARCHAR(150) NULL DEFAULT NULL,
    phone           VARCHAR(30)  NULL DEFAULT NULL,
    address         TEXT         NULL,
    case_status     ENUM('laporan','dropped','closed','monitoring') NOT NULL DEFAULT 'laporan',
    status          ENUM('draft','published') NOT NULL DEFAULT 'draft',
    legacy_ref      VARCHAR(120) NULL DEFAULT NULL,
    created_at      DATETIME     NOT NULL,
    updated_at      DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_grievances_legacy_ref (legacy_ref),
    KEY idx_grievances_public (status, case_status, reported_on)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
