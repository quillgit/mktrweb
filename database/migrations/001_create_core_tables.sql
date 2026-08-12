-- Core tables: locales, roles, users, settings.
-- Indexed VARCHARs are capped at 191 so utf8mb4 keys fit the 767-byte limit
-- on older MySQL/MariaDB builds, which is what shared cPanel hosts tend to run.

CREATE TABLE IF NOT EXISTS locales (
    code       VARCHAR(5)   NOT NULL,
    name       VARCHAR(64)  NOT NULL,
    is_default TINYINT(1)   NOT NULL DEFAULT 0,
    sort       SMALLINT     NOT NULL DEFAULT 0,
    PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS roles (
    id   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug VARCHAR(32)  NOT NULL,
    name VARCHAR(64)  NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_roles_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    role_id       INT UNSIGNED NOT NULL,
    name          VARCHAR(120) NOT NULL,
    username      VARCHAR(64)  NOT NULL,
    email         VARCHAR(191) NOT NULL,
    -- password_hash() output; never a plain or legacy hash.
    password      VARCHAR(255) NOT NULL,
    status        TINYINT(1)   NOT NULL DEFAULT 1,
    last_login_at DATETIME     NULL DEFAULT NULL,
    created_at    DATETIME     NOT NULL,
    updated_at    DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_users_username (username),
    UNIQUE KEY uniq_users_email (email),
    KEY idx_users_role (role_id),
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(120) NOT NULL,
    value       LONGTEXT     NULL,
    updated_at  DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO locales (code, name, is_default, sort) VALUES ('id', 'Indonesia', 1, 1);
INSERT IGNORE INTO locales (code, name, is_default, sort) VALUES ('en', 'English', 0, 2);

INSERT IGNORE INTO roles (id, slug, name) VALUES (1, 'admin', 'Administrator');
INSERT IGNORE INTO roles (id, slug, name) VALUES (2, 'editor', 'Editor');
INSERT IGNORE INTO roles (id, slug, name) VALUES (3, 'contributor', 'Kontributor');
