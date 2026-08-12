-- Editable site-wide content that belongs to no single page.
--
-- The home page opens with an "about" block whose text and two photographs
-- live in `tabel_home` — a one-row table. The footer address, the corporate
-- email and the social links were not in the database at all: they were typed
-- into every one of the 28 modules, so changing the office address meant a
-- code deploy.
--
-- Both become settings. `value` holds anything that is the same in every
-- locale (an email address, a URL); anything a translator touches lives in
-- site_setting_translations instead.

CREATE TABLE IF NOT EXISTS site_settings (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    -- Groups the admin screen renders as sections.
    `group`      VARCHAR(40)  NOT NULL DEFAULT 'general',
    `key`        VARCHAR(80)  NOT NULL,
    -- Locale-independent value; translated text goes in the translations table.
    value        TEXT         NULL,
    media_id     INT UNSIGNED NULL DEFAULT NULL,
    media_2_id   INT UNSIGNED NULL DEFAULT NULL,
    sort         SMALLINT     NOT NULL DEFAULT 0,
    updated_at   DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_site_settings_key (`key`),
    KEY idx_site_settings_group (`group`, sort),
    CONSTRAINT fk_ss_media FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE SET NULL,
    CONSTRAINT fk_ss_media_2 FOREIGN KEY (media_2_id) REFERENCES media (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS site_setting_translations (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    setting_id INT UNSIGNED NOT NULL,
    locale     VARCHAR(5)   NOT NULL,
    value      LONGTEXT     NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_sst_setting_locale (setting_id, locale),
    CONSTRAINT fk_sst_setting FOREIGN KEY (setting_id) REFERENCES site_settings (id) ON DELETE CASCADE,
    CONSTRAINT fk_sst_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- The keys the application reads. Values are filled by the importer (home.*)
-- or edited in the CMS; a missing row falls back to the template default, so
-- an empty table never breaks a page.
INSERT INTO site_settings (`group`, `key`, value, sort, updated_at) VALUES
    ('home',    'home.intro_title',  NULL, 1, NOW()),
    ('home',    'home.intro_body',   NULL, 2, NOW()),
    ('contact', 'contact.address',   NULL, 1, NOW()),
    ('contact', 'contact.email',     'corsec@mktr.co.id', 2, NOW()),
    ('contact', 'contact.phone',     NULL, 3, NOW()),
    ('social',  'social.instagram',  'https://instagram.com/mktr.id', 1, NOW()),
    ('social',  'social.youtube',    'https://www.youtube.com/@mktr5433', 2, NOW()),
    ('social',  'social.facebook',   'https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604', 3, NOW()),
    ('social',  'social.linkedin',   'https://www.linkedin.com/company/pt-menthobi-karyatama-raya/', 4, NOW())
ON DUPLICATE KEY UPDATE `group` = VALUES(`group`);
