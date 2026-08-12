-- Grievances submitted through the public form need the same provenance the
-- inquiries table already carries: without an IP the abuse throttle has
-- nothing to count, and without a submitted_at a row imported from the legacy
-- table is indistinguishable from one filed this morning.
--
-- The legacy form wrote status = '1' (unpublished) and status_laporan =
-- 'laporan', so a submission never appears on the public register until
-- somebody moves the case forward. That behaviour is unchanged; these columns
-- only record where the row came from.

ALTER TABLE grievances
    ADD COLUMN ip           VARCHAR(45)  NULL DEFAULT NULL AFTER address,
    ADD COLUMN user_agent   VARCHAR(255) NULL DEFAULT NULL AFTER ip,
    ADD COLUMN submitted_at DATETIME     NULL DEFAULT NULL AFTER user_agent;

ALTER TABLE grievances
    ADD KEY idx_grievances_throttle (ip, created_at);
