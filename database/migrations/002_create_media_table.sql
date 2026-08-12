-- Media library.
-- The legacy site scattered uploads across images/post, images/penghargaan,
-- images/manajemen, images/banner … with no record of what a file was or where
-- it was used. Every upload is now a row here and referenced by id.

CREATE TABLE IF NOT EXISTS media (
    id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    -- Root-relative public path, e.g. /storage/uploads/2026/08/ab12….jpg
    path        VARCHAR(255)  NOT NULL,
    -- Original filename as uploaded, kept for display only.
    filename    VARCHAR(191)  NOT NULL,
    mime        VARCHAR(100)  NOT NULL,
    size        INT UNSIGNED  NOT NULL DEFAULT 0,
    width       INT UNSIGNED  NULL DEFAULT NULL,
    height      INT UNSIGNED  NULL DEFAULT NULL,
    alt         VARCHAR(255)  NULL DEFAULT NULL,
    title       VARCHAR(255)  NULL DEFAULT NULL,
    folder      VARCHAR(64)   NOT NULL DEFAULT '',
    uploaded_by INT UNSIGNED  NULL DEFAULT NULL,
    created_at  DATETIME      NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_media_path (path),
    KEY idx_media_created (created_at),
    KEY idx_media_uploader (uploaded_by),
    CONSTRAINT fk_media_uploader FOREIGN KEY (uploaded_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
