-- Careers, from tabel_lowongan_kerja.

CREATE TABLE IF NOT EXISTS jobs (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug           VARCHAR(191) NOT NULL,
    cover_media_id INT UNSIGNED NULL DEFAULT NULL,
    location       VARCHAR(150) NULL DEFAULT NULL,
    closes_on      DATE         NULL DEFAULT NULL,
    status         ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
    published_at   DATETIME     NULL DEFAULT NULL,
    legacy_ref     VARCHAR(120) NULL DEFAULT NULL,
    created_at     DATETIME     NOT NULL,
    updated_at     DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_jobs_slug (slug),
    UNIQUE KEY uniq_jobs_legacy_ref (legacy_ref),
    KEY idx_jobs_listing (status, published_at),
    CONSTRAINT fk_jobs_cover FOREIGN KEY (cover_media_id) REFERENCES media (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS job_translations (
    id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    job_id           INT UNSIGNED NOT NULL,
    locale           VARCHAR(5)   NOT NULL,
    slug             VARCHAR(191) NULL DEFAULT NULL,
    title            VARCHAR(255) NOT NULL,
    body             LONGTEXT     NULL,
    meta_title       VARCHAR(255) NULL DEFAULT NULL,
    meta_description VARCHAR(500) NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_job_locale (job_id, locale),
    CONSTRAINT fk_jt_job FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE,
    CONSTRAINT fk_jt_locale FOREIGN KEY (locale) REFERENCES locales (code) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
