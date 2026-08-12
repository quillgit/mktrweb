-- Investor documents.
--
-- Replaces 19 near-identical tabel_laporan_* tables and the 20 admin modules
-- that maintained them. The legacy tables all carried the same shape
-- (title, title_english, gambar, file_dokumen, status, created, author) with
-- three variations that are preserved here rather than flattened:
--
--   * laporan_date  -> documents.document_date   (dated report lists)
--   * gambar        -> documents.cover_media_id  (report cover thumbnails)
--   * sub_title     -> document_translations.description
--
-- Presentation moves from code to data: module/hubungan_investor.php had a
-- hardcoded branch per slug choosing between a dated list and a cover grid.
-- That is now document_categories.layout.

CREATE TABLE IF NOT EXISTS document_categories (
    id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug   VARCHAR(120) NOT NULL,
    layout ENUM('list','cover-grid') NOT NULL DEFAULT 'list',
    sort   SMALLINT     NOT NULL DEFAULT 0,
    status TINYINT(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_document_categories_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS document_category_translations (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id INT UNSIGNED NOT NULL,
    locale      VARCHAR(5)   NOT NULL,
    name        VARCHAR(191) NOT NULL,
    description TEXT         NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_dct_category_locale (category_id, locale),
    KEY idx_dct_locale (locale),
    CONSTRAINT fk_dct_category FOREIGN KEY (category_id) REFERENCES document_categories (id) ON DELETE CASCADE,
    CONSTRAINT fk_dct_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documents (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id    INT UNSIGNED NOT NULL,
    -- The PDF itself.
    file_media_id  INT UNSIGNED NULL DEFAULT NULL,
    -- Optional report cover image, used by the 'cover-grid' layout.
    cover_media_id INT UNSIGNED NULL DEFAULT NULL,
    document_date  DATE         NULL DEFAULT NULL,
    -- Denormalised from document_date so the year filter stays a plain index.
    year           SMALLINT     NULL DEFAULT NULL,
    sort           SMALLINT     NOT NULL DEFAULT 0,
    status         ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
    published_at   DATETIME     NULL DEFAULT NULL,
    downloads      INT UNSIGNED NOT NULL DEFAULT 0,
    -- 'tabel_laporan_tahunan:42' — makes the legacy import idempotent and
    -- keeps a traceable link back to the source row.
    legacy_ref     VARCHAR(120) NULL DEFAULT NULL,
    created_at     DATETIME     NOT NULL,
    updated_at     DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_documents_legacy_ref (legacy_ref),
    KEY idx_documents_listing (category_id, status, published_at),
    KEY idx_documents_year (category_id, year),
    KEY idx_documents_file (file_media_id),
    KEY idx_documents_cover (cover_media_id),
    CONSTRAINT fk_documents_category FOREIGN KEY (category_id) REFERENCES document_categories (id) ON DELETE CASCADE,
    CONSTRAINT fk_documents_file FOREIGN KEY (file_media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_documents_cover FOREIGN KEY (cover_media_id) REFERENCES media (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS document_translations (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    document_id INT UNSIGNED NOT NULL,
    locale      VARCHAR(5)   NOT NULL,
    title       VARCHAR(255) NOT NULL,
    description TEXT         NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_dt_document_locale (document_id, locale),
    KEY idx_dt_locale (locale),
    CONSTRAINT fk_dt_document FOREIGN KEY (document_id) REFERENCES documents (id) ON DELETE CASCADE,
    CONSTRAINT fk_dt_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- The 19 categories, mapped from the legacy tables. `layout` reproduces how
-- module/hubungan_investor.php rendered each one.
INSERT IGNORE INTO document_categories (id, slug, layout, sort) VALUES
    (1,  'laporan-tahunan',              'cover-grid', 1),
    (2,  'laporan-keberlanjutan',        'cover-grid', 2),
    (3,  'laporan-keuangan',             'list',       3),
    (4,  'prospektus',                   'list',       4),
    (5,  'keterbukaan-informasi',        'list',       5),
    (6,  'presentasi-perusahaan',        'cover-grid', 6),
    (7,  'buletin-investor',             'list',       7),
    (8,  'laporan-operasional',          'list',       8),
    (9,  'rups',                         'list',       9),
    (10, 'anggaran-dasar',               'list',       10),
    (11, 'kebijakan',                    'list',       11),
    (12, 'kebijakan-tata-kelola',        'list',       12),
    (13, 'pedoman',                      'list',       13),
    (14, 'laporan-kekayaan',             'list',       14),
    (15, 'laporan-keluhan',              'list',       15),
    (16, 'transaksi-afiliasi',           'list',       16),
    (17, 'sertifikasi',                  'cover-grid', 17),
    (18, 'laporan-rspo',                 'list',       18),
    (19, 'rencana-kerja',                'list',       19);

INSERT IGNORE INTO document_category_translations (category_id, locale, name) VALUES
    (1,  'id', 'Laporan Tahunan'),                  (1,  'en', 'Annual Report'),
    (2,  'id', 'Laporan Keberlanjutan'),            (2,  'en', 'Sustainability Report'),
    (3,  'id', 'Laporan Keuangan'),                 (3,  'en', 'Financial Report'),
    (4,  'id', 'Prospektus'),                       (4,  'en', 'Prospectus'),
    (5,  'id', 'Keterbukaan Informasi'),            (5,  'en', 'Information Disclosure'),
    (6,  'id', 'Presentasi Perusahaan'),            (6,  'en', 'Corporate Presentation'),
    (7,  'id', 'Buletin Investor'),                 (7,  'en', 'Investor Bulletin'),
    (8,  'id', 'Laporan Operasional'),              (8,  'en', 'Operational Report'),
    (9,  'id', 'RUPS'),                             (9,  'en', 'General Meeting of Shareholders'),
    (10, 'id', 'Anggaran Dasar'),                   (10, 'en', 'Articles of Association'),
    (11, 'id', 'Kebijakan'),                        (11, 'en', 'Policies'),
    (12, 'id', 'Kebijakan Tata Kelola'),            (12, 'en', 'Governance Policies'),
    (13, 'id', 'Pedoman'),                          (13, 'en', 'Guidelines'),
    (14, 'id', 'Laporan Kekayaan'),                 (14, 'en', 'Asset Report'),
    (15, 'id', 'Laporan Keluhan'),                  (15, 'en', 'Grievance Report'),
    (16, 'id', 'Transaksi Afiliasi'),               (16, 'en', 'Affiliated Transactions'),
    (17, 'id', 'Sertifikasi'),                      (17, 'en', 'Certifications'),
    (18, 'id', 'Laporan RSPO'),                     (18, 'en', 'RSPO Report'),
    (19, 'id', 'Rencana Kerja'),                    (19, 'en', 'Work Plan');
