-- Content revisions.
--
-- A snapshot of the full translatable payload is written on every save, so an
-- editor can see what changed and roll back. Polymorphic on purpose: pages,
-- documents and jobs reuse this table in later phases without a schema change.

CREATE TABLE IF NOT EXISTS revisions (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    revisable_type VARCHAR(40)  NOT NULL,
    revisable_id   INT UNSIGNED NOT NULL,
    -- JSON snapshot of the record plus every locale's translation row.
    payload        LONGTEXT     NOT NULL,
    note           VARCHAR(191) NULL DEFAULT NULL,
    created_by     INT UNSIGNED NULL DEFAULT NULL,
    created_at     DATETIME     NOT NULL,
    PRIMARY KEY (id),
    KEY idx_revisions_target (revisable_type, revisable_id, id),
    KEY idx_revisions_author (created_by),
    CONSTRAINT fk_revisions_author FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
