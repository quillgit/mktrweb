# Cutover runbook

Moving the rebuilt application from `/v2` to the document root, and retiring the legacy site.

The two applications share a webroot but nothing else — separate code, separate database,
separate admin. That is what makes this reversible: until step 6 the legacy site is still
serving, and rolling back is one `.htaccess` swap.

---

## 0. Before the day

| | |
|---|---|
| **PHP** | The host is PHP 7.4. This repository has only been *parsed* by 7.4-compatible checks (`database/check-php74.php`), never executed on 7.4 — nothing here has been run on the real interpreter. Run `php -l` on the server across `app/`, `config/`, `database/` and `v2/` **before** anything else, and load `/v2` on the real host once the code is deployed. |
| **Credentials** | `configuration/connection.php` (and the `en/` and `adminpanel/` copies) contain the live database username and password in git history. Rotate them. The rebuild reads credentials from the environment (`DB_*`), so set those in cPanel rather than committing them. |
| **APP_KEY** | `config/app.php` ships a development key. Set `APP_KEY` to a long random string in the environment; it signs session fingerprints and preview tokens. Changing it later logs everyone out and invalidates outstanding preview links. |
| **Backups** | Dump the legacy database and tar the webroot. Keep both off the host. |

---

## 1. Deploy the code

Deploy the branch to the webroot. `module/`, `en/`, `adminpanel/`, `configuration/` and the root
`index.php` are untouched by the rebuild and keep serving the live site.

```
php -l on every file under app/ config/ database/ v2/
php database/check-php74.php        # must report nothing
```

## 2. Create the schema

```
DB_DATABASE=mktr_v2 php database/migrate.php
```

Migrations are idempotent and tracked, so re-running is safe. Do **not** run `database/seed.php`
on a database that already holds imported data — it refuses, but do not rely on that.

Create the first administrator, then delete the seeded demo account if one exists.

## 3. Import the legacy content

Point the `LEGACY_DB_*` environment variables at the live database (read-only credentials are
enough) and dry-run first:

```
php database/import/run.php --dry-run
```

The reconciliation report must say **BALANCED** before writing. Then:

```
php database/import/run.php
php database/import/run.php        # second run proves idempotency: 0 imported, N updated
```

Expected counts from the production dump:

| Source | Rows |
|---|---|
| documents | 143 (19 `tabel_laporan_*` tables; `tabel_laporan_keluhan` is **not** one of them) |
| posts | 20 |
| pages | 100 |
| jobs | 3 |
| collections + inquiries | 37 |
| settings | 1 (`tabel_home`) |

Two checks that must pass, because getting them wrong publishes private data:

```sql
-- No grievance submission may reach the public documents listing.
SELECT COUNT(*) FROM documents WHERE legacy_ref LIKE 'tabel_laporan_keluhan%';   -- must be 0

-- The public register may only show cases past the initial report stage.
SELECT COUNT(*) FROM grievances WHERE status = 'published' AND case_status = 'laporan'; -- must be 0
```

## 4. Verify against the running site

With the rebuild reachable at `/v2` on the real host:

```
php database/route-parity.php https://mktr.co.id/v2
```

Every URL in SPEC.md §4 must return 200 in both locales, and unknown slugs must return 404.
The check exits non-zero on any failure, so it can gate the next step.

Then by hand: log in to `/v2/admin`, publish a test post, confirm it appears on `/v2/berita` and
disappears when set back to draft, and submit each of the three public forms and find them in
`/v2/admin/inquiries`.

## 5. Files on disk

`images/` and `dokumen/` are shared: the importer registers the existing files where they are and
never copies or moves them, and every imported media row is flagged `is_external = 1` so deleting
it in the CMS cannot unlink the original. Nothing to migrate — but do not delete those folders
when the legacy code goes.

New uploads land in `storage/uploads/`, which must be writable by the web user.

## 6. Switch the document root

1. Move `v2/index.php` to the webroot as `index.php` (keeping the legacy one as
   `index.legacy.php`), and replace the root `.htaccess` with `v2/.htaccess`, changing
   `RewriteBase /v2/` to `RewriteBase /`.
2. Set `APP_BASE_PATH=''`. Leave `APP_ASSET_BASE` empty — assets already resolve from the
   document root, which is why they keep working across the move.
3. Reload one page of each type and re-run `route-parity.php` against the root URL.

**Rollback**: restore the old `index.php` and `.htaccess` and set `APP_BASE_PATH=/v2`. The legacy
code and its database were never modified, so this is complete.

## 7. After the switch

- Keep `module/`, `en/`, `adminpanel/` and the legacy database in place, untouched, for at least
  one full reporting cycle. Retire them only once nobody has needed them.
- Point the legacy admin's users at the new one and disable `adminpanel/` login.
- Set `APP_DEBUG=0`. Confirm `display_errors` is off in `.htaccess` and `php.ini` — the legacy
  configuration turns it on.
- Submit `sitemap.xml` again if the search console has one cached.

---

## What does not change

URLs. Every path the legacy `.htaccess` rewrote resolves in the rebuild, including
`/mktr_so/{slug}`, `/read/{id}/{slug}`, `/apply/{id}/{slug}` and `/cari/{slug}`. The one
behavioural difference is deliberate: an unknown slug now returns a real 404 instead of a
JavaScript redirect to the home page.

The `en/` fork is not migrated. English is a locale prefix (`/en/...`) served by the same code,
which is what removes the second copy of every file. `en/` keeps working until step 6 and can be
deleted with the rest of the legacy tree.
