# MKTR Website — Codebase Specification

Shared reference for `mktr.co.id`, the corporate and investor-relations website of
**PT Menthobi Karyatama Raya Tbk** (IDX: MKTR), a listed Indonesian palm-oil plantation company.

> **Audience:** anyone touching this repo. Read §7 (Conventions) and §8 (Rules of engagement)
> before your first change — this codebase has non-obvious constraints that will bite you.

---

## 1. Stack

| Layer | What |
|---|---|
| Runtime | PHP 7.4 on cPanel (`AddHandler application/x-httpd-ea-php74` in `.htaccess`) |
| Style | Procedural PHP. No framework, no autoloader, no build step, no package manager on the frontend. |
| Database | MySQL, accessed through **deprecated `mysql_*` calls** kept alive by a compatibility shim |
| CSS | Bootstrap **5.0.0-beta3** + a purchased HTML template ("erepair") + 21 per-section sheets |
| JS | jQuery 3.7.1 + 21 plugins. No modules, no bundler. |
| Deploy | Files served directly from the webroot. Editing a file in place is a deploy. |

There is no test suite, no CI, and no staging environment in this repo.

---

## 2. Request lifecycle

```
Browser
  │
  └─ .htaccess ─────────────── force HTTPS · pretty-URL rewrites · ErrorDocument 404
                               · blocks TRACE/DELETE/TRACK/DEBUG and SQL-ish query strings
       │
       └─ index.php ────────── session_start()
            │
            ├─ parser-php-version.php ......... 3rd-party mysql_* → mysqli_* shim
            │                                   (public-domain, dotpointer). The site still
            │                                   writes mysql_*; this file makes it run on PHP 7+.
            ├─ configuration/connection.php ... mysql_connect() + mysql_select_db()
            ├─ configuration/function.php ..... konten(), header_menu(), formatting helpers
            ├─ configuration/path.php ......... $nama_folder = "https://mktr.co.id"
            │
            ├─ [lines  16–657] per-route SEO if/else chain — <title>, OG tags, meta per `sct`
            ├─ [lines 659–727] <head>: favicon, Google Fonts, 24 CSS links, gtag, reCAPTCHA
            ├─ [line      742] konten()  ◄── THE ROUTER
            ├─ [lines 750–1020] inline <footer class="site-footer"> (large block, partly commented)
            └─ [lines   1024+] 22 <script> tags
```

Every page is `index.php`. There is no front controller class, no dispatch table — just
`if/else` on `$_GET['sct']`.

### The router

`konten()` — `configuration/function.php:3` — is a flat `if/else` chain that `include`s exactly one
file from `module/`:

```php
function konten(){
    if (empty($_GET['sct'])){
        include "module/home.php";
    }else if ($_GET['sct']=='profil_kami'){
        include "module/profil_kami.php";
    } ... else {
        include "module/home.php";   // fallback
    }
}
```

### The navigation

`header_menu()` — `configuration/function.php:134` — emits `<nav class="main-menu">`. The
"Tentang Kami" branch is hardcoded; **every other dropdown is built live from the database**
(`tabel_bisnis_inti`, `tabel_berkelanjutan`, `tabel_tatakelola_perusahaan`, `tabel_tentang_kami`,
`tabel_sumber_daya`), each filtered by `status = '2'`. Editing menu labels usually means editing
data in the adminpanel, not editing PHP.

---

## 3. Directory inventory

| Path | Role |
|---|---|
| `index.php` (1051 L) | Sole entry point: SEO chain + `<head>` + page shell + footer + scripts |
| `configuration/connection.php` | DB credentials + connect. **Credentials are committed.** |
| `configuration/function.php` (514 L) | Router, nav builder, date/format/escape helpers |
| `configuration/path.php` | `$nama_folder` — the absolute base URL used by every link |
| `module/` (28 files) | One file per page — see §4 |
| `assets/css/` | 24 vendor + template stylesheets incl. `style.css` (2878 L), `responsive.css` (2400 L) |
| `assets/css/module-css/` | 21 per-section sheets, all linked unconditionally on every page |
| `assets/js/` (22 files) | jQuery, bootstrap.bundle, swiper, owl, wow, isotope, jarallax, magnific-popup, odometer, sweetalert, fslightbox, `script.js` (1086 L) |
| `assets/images/` (~98 MB) | Template + brand imagery |
| `images/` | CMS uploads, foldered by type (`post/`, `penghargaan/`, `manajemen/`, `banner/`, …) |
| `dokumen/` (133 files, 271 MB) | Annual & sustainability reports, prospectuses — static PDFs |
| `en/` | **Near-complete fork of the entire site** — see §6 |
| `adminpanel/` | Separate legacy CMS (own auth, own assets, TinyMCE) that writes the tables the frontend reads |
| `components/`, `VMBudayaKerja.php` | **Dead code** — see §5 |
| `parser-php-version.php` | mysql→mysqli shim (also duplicated in `en/` and `adminpanel/`) |
| `kodeacak.php` | Random-code helper |

---

## 4. Routes

`.htaccess` rewrites a pretty URL to `index.php?sct=<name>`; `konten()` maps `sct` to a module.

### Simple routes

| URL | `sct` | Module |
|---|---|---|
| `/` | *(empty)* | `module/home.php` |
| `/profil_kami` | `profil_kami` | `module/profil_kami.php` |
| `/logo_kami` | `logo_kami` | `module/logo_kami.php` |
| `/visi_misi` | `visi_misi` | `module/visi_misi.php` |
| `/peristiwa_penting` | `peristiwa_penting` | `module/peristiwa_penting.php` |
| `/struktur_kepemilikan` | `struktur_kepemilikan` | `module/struktur_kepemilikan.php` |
| `/struktur_organisasi` | `struktur_organisasi` | `module/struktur_organisasi.php` |
| `/dewan_komisaris` | `dewan_komisaris` | `module/dewan_komisaris.php` |
| `/direksi` | `direksi` | `module/direksi.php` |
| `/struktur_group` | `struktur_group` | `module/struktur_group.php` |
| `/anak_perusahaan_kami` | `anak_perusahaan_kami` | `module/anak_perusahaan_kami.php` |
| `/penghargaan` | `penghargaan` | `module/penghargaan.php` |
| `/keanggotaan` | `keanggotaan` | `module/keanggotaan.php` |
| `/berita` | `berita` | `module/berita.php` |
| `/karir` | `karir` | `module/karir.php` |
| `/kontak_kami` | `kontak_kami` | `module/kontak_kami.php` |
| `/form_grievance` | `form_grievance` | `module/form_grievance.php` |
| `/pelaporan_pelanggaran` | `pelaporan_pelanggaran` | `module/pelaporan_pelanggaran.php` |
| `/pencarian` | `pencarian` | `module/pencarian.php` |
| *(404 handler)* | `404` | `module/404.php` |

### Slug / id routes

| URL pattern | `sct` | Extra params |
|---|---|---|
| `/bisnis/{slug}` | `bisnis_inti` | `slug` |
| `/keberlanjutan/{slug}` | `keberlanjutan` | `slug` |
| `/tatakelola_perusahaan/{slug}` | `tatakelola_perusahaan` | `slug` |
| `/sdm/{slug}` | `sdm` | `slug` |
| `/hubungan_investor/{slug}` | `hubungan_investor` | `slug` |
| `/mktr_so/{slug}` | `mktr_so` | `slug` |
| `/cari/{slug}` | `cari` | `slug` |
| `/read/{id}/{slug}` | `berita_detail` | `id_berita`, `slug` |
| `/apply/{id}/{slug}` | `karir_detail` | `id_lowongan_kerja`, `slug` |
| `/berita/{page}` | `berita` | `page` |

### Module anatomy

Every module is self-contained and repeats the same scaffold inline:

```php
<?php include "configuration/path.php"; ?>

<header class="main-header">
    <div class="main-menu__top"> … language switcher (ID | EN) + social icons … </div>
    <?php header_menu(); ?>
</header>

<section class="page-header"> … <h3>Title</h3> + .thm-breadcrumb … </section>

<!-- ~12 modules then repeat this hardcoded sidebar: -->
<div class="service-details__services-box">
    <ul class="service-details__services-list"> … sibling page links, one marked .active … </ul>
</div>

<!-- page content: mysql_query() + while(mysql_fetch_array()) loop -->
```

There is **no shared page-header or sidebar partial**. Adding a page under "Tentang Kami" means
editing the sidebar list in every sibling module.

---

## 5. Dead code

`components/*.php` (`navbar.php`, `footer.php`, `style-navbar.php`, `style-navbar2.php`,
`style-footer.php`) and `VMBudayaKerja.php` are leftovers from a **previous generation of the site**:

- `VMBudayaKerja.php` is only linked from `components/navbar.php`.
- `components/navbar.php` is only included by `VMBudayaKerja.php`.
- That closed loop is unreachable from `index.php`, from `konten()`, and from `.htaccess`.
- Its links point at `SEKILASPERUSAHAAN.php`, `manajemen.php`, `tata-kelola.php`,
  `aktifitas-bisnis.php`, `berita.php`, `informasi-keuangan.php` — **none of which exist**.

The live navigation is `header_menu()` in `configuration/function.php`. Do not edit `components/`
expecting to change the site.

---

## 6. The `en/` fork

`en/` is not a translation layer. It is a **near-complete copy of the whole application**:

```
en/index.php                 1031 L   (vs 1051 L at root)
en/configuration/            connection.php · function.php (514 L) · path.php
en/module/                   22 files — the same modules, plus peristiwa_penting_v1.php
en/parser-php-version.php    another copy of the shim
en/.htaccess                 its own rewrite set
```

`en/` links back to the **shared** `assets/` tree, so stylesheets and scripts are not duplicated.

> **Rule:** any change to `index.php`, `configuration/function.php`, or a `module/*.php` must be
> mirrored in `en/`. A CSS-only change does not need mirroring.

---

## 7. Conventions

### Database

33 `tabel_*` tables are read by the frontend (66 exist across the repo including adminpanel).

**Content tables:** `tabel_home`, `tabel_about_us`, `tabel_berita`, `tabel_bisnis_inti`,
`tabel_berkelanjutan`, `tabel_tatakelola_perusahaan`, `tabel_tentang_kami`, `tabel_sumber_daya`,
`tabel_struktur_organisasi`, `tabel_perusahaan`, `tabel_penghargaan`, `tabel_keanggotaan`,
`tabel_lowongan_kerja`, `tabel_jejak_perusahaan`.

**Document tables (~18):** `tabel_laporan_tahunan`, `tabel_laporan_keuangan`,
`tabel_laporan_keberlanjutan`, `tabel_laporan_prospektus`, `tabel_laporan_rups`,
`tabel_laporan_operasional`, `tabel_laporan_rspo`, `tabel_laporan_kebijakan`,
`tabel_laporan_kebijakan_tatakelola`, `tabel_laporan_pedoman`, `tabel_laporan_anggaran_dasar`,
`tabel_laporan_buletin_investor`, `tabel_laporan_kekayaan`, `tabel_laporan_keluhan`,
`tabel_laporan_keterbukaan_informasi`, `tabel_laporan_plan`,
`tabel_laporan_presentasi_perusahaan`, `tabel_laporan_setifikasi`,
`tabel_laporan_transaksi_afiliasi`. These point at files in `dokumen/`.

Three conventions apply almost everywhere:

1. **Bilingual = paired columns, same row.** `sub_title` / `sub_title_english`,
   `description` / `description_english`, `slug` / `slug_english`, `title` / `title_english`.
   The `en/` fork selects the `_english` variant. There is no locale table.
2. **Hierarchy = self-reference.** `kategori` is `parent` / `child` / *(other)*, and `child` holds
   the parent's id. Top-level menu queries filter `kategori != 'child'`; children are fetched with
   `WHERE child = '<parent id>'`.
3. **Publication = `status = '2'`.** Menu and listing queries filter on it. Other values are drafts.

### Primary keys

`id_<table-suffix>` — e.g. `tabel_berkelanjutan.id_berkelanjutan`,
`tabel_tentang_kami.id_tentang_kami`, `tabel_lowongan_kerja.id_lowongan_kerja`.

### Helpers (`configuration/function.php`)

| Function | Purpose |
|---|---|
| `konten()` | The router |
| `header_menu()` | Renders the main nav (DB-driven) |
| `slug($str)` | Lowercase + non-alphanumerics to `-` |
| `limitWord($string, $n)` | Truncate to *n* words |
| `TanggalIndo($date)` | `12 Agustus 2026` |
| `TanggalIndon($date)` | `12 Agustus 2026 Pukul 14:30:00 WIB` |
| `TanggalBulan($date)` | `12<br>Agu` — for date badges |
| `format_rupiah($angka)` | Thousands separator |
| `antiinjection($data)` | `htmlspecialchars` → `strip_tags` → `stripslashes` → `mysql_real_escape_string` |
| `IntervalDays($in, $out)` | Day difference |
| `give_alert($pesan)` / `go_to($path)` | `<script>` alert / redirect |

**`$nama_folder`** (`configuration/path.php`) is the absolute base URL. Every internal link is
built as `<?php echo "$nama_folder/route"; ?>`. Modules `include "configuration/path.php"` at the
top to get it in scope.

### CSS

Design tokens live in `assets/css/style.css` `:root` under an `--erepair-*` prefix (the template's
name). All 21 `module-css/` sheets resolve their colors through those variables, so redefining them
in a later-loaded stylesheet re-skins the whole site without touching the sheets themselves.

Load order in `<head>` (later wins):

```
bootstrap → animate → custom-animate → swiper → font-awesome → jarallax → magnific-popup
→ odometer → flaticon → owl → nice-select → jquery-ui → twentytwenty
→ module-css/*.css (21 files)
→ style.css → responsive.css → theme-refresh.css
```

`assets/css/theme-refresh.css` is the **project's own** layer — the only stylesheet here that is not
vendor or template code. Put new styling there; do not edit the template sheets.

---

## 8. Rules of engagement

1. **Mirror into `en/`.** PHP changes to `index.php`, `configuration/`, or `module/` must be applied
   twice. CSS changes need not be.
2. **Style in `theme-refresh.css`.** It loads last and reaches every page. Editing `style.css`,
   `responsive.css`, or `module-css/*` means editing vendor/template code.
3. **`$nama_folder` for every internal link.** Relative links break under the rewrite rules.
4. **`status = '2'` on every content query**, or drafts leak to production.
5. **Don't touch `components/` or `VMBudayaKerja.php`.** They are unreachable (§5).
6. **Editing a file is a deploy.** There is no build and no staging.

---

## 8b. The rebuild (`/v2`)

A replacement application runs alongside this one at `/v2`, sharing the webroot but nothing else.
It is documented here so the two are not confused.

| | Legacy (this document) | Rebuild |
|---|---|---|
| Entry | `index.php` at the root | `v2/index.php` front controller |
| Routing | `konten()` if/else | route table in `config/routes.php` |
| Database | `mysql_*`, interpolated SQL | PDO, prepared statements |
| Languages | `en/` fork of the whole app | locale URL prefix, one codebase |
| Admin | `adminpanel/` | `/v2/admin` |

Shipped so far: Content Pages, News, Investor Documents and Careers, plus the media library,
authentication with roles, draft/scheduled/published workflow, signed previews and revision
history. **Production data has been imported** — 100 pages, 143 documents, 20 posts, 3 vacancies.

**Content pages.** One `pages` table replaces six legacy tables
(`about_us`, `bisnis_inti`, `berkelanjutan`, `tatakelola_perusahaan`, `tentang_kami`,
`sumber_daya`). The legacy `kategori` (parent/child/single) + `child` pair collapses to
`parent_id`, and the legacy `tipe` becomes `type` — `text`, `documents` or `grievances` — so a
page decides its own presentation instead of the router branching per slug. The site navigation
and every section sidebar are built from this table, replacing markup that was hardcoded in all
28 module files.

**Grievance register.** `tabel_laporan_keluhan` is named like a report table but holds grievance
submissions with names, addresses, emails and phone numbers, and has no file column. It is
imported into `grievances`, not `documents`. The public register at
`/keberlanjutan/daftar-pengaduan` shows only what the legacy page published — date, channel,
organisation, reporter, status — and `Grievance::publicRegister()` cannot return the contact
fields at all.

**Investor documents.** One `documents` table replaces the 19 `tabel_laporan_*` tables, and one
admin screen replaces the 20 `adminpanel/modules/laporan_*.php` modules. `document_categories.layout`
(`list` or `cover-grid`) reproduces the two presentations that `module/hubungan_investor.php`
hardcoded per slug, so a new report type is a row rather than a new table, module and code branch.

**Legacy import.** `database/import/` reads this database read-only and writes the new schema. It
introspects each source table rather than assuming columns, because the `tabel_laporan_*` tables
disagree with one another (`laporan_date` on some, `gambar` on others, `sub_title` on one). Every
imported row carries a `legacy_ref` of `<source table>:<source id>` under a unique index, so the
import is idempotent and traceable. Run `php database/import/run.php --dry-run` first; it prints a
reconciliation report that must balance before cutover.

---

## 9. Known issues

### Fixed in the current pass

| # | Issue |
|---|---|
| F1 | `var(--erepair-primary)` was used 34× while the variable was commented out — every one of those declarations was invalid and dropped. Variable restored. |
| F2 | `--erepair-base-rgb: 42,185,126` did not match `--erepair-base: #307c54` (`48,124,84`), so all 16 `rgba(var(--erepair-base-rgb),…)` tints rendered the wrong green. Brought into agreement. |
| F3 | `ErrorDocument 404` routed to `module/404.php`, **which did not exist** — the 404 page emitted a warning and rendered empty. Module added (ID + EN). |
| F4 | The router's final `else` did `include "home.php"` (no such file at root; should be `module/home.php`), so any unrecognised `sct` produced a blank page. Path corrected. |
| F5 | `--erepair-font-3: "Pacifico"` was declared but never loaded. Resolved. |

### Open — not addressed

**Security**
- DB credentials are committed in `configuration/connection.php` (and the `en/` + `adminpanel/`
  copies). Rotate them and move to an untracked config outside the webroot.
- Site-wide `mysql_*` with string-interpolated SQL. `antiinjection()` exists but is not applied
  consistently. Slug/id params reach queries directly in places.
- `display_errors On` in production (`.htaccess`, `php.ini`).

**Performance**
- 350 images over 500 KB; the largest is 17 MB (`assets/images/resources/image.png`). No
  `loading="lazy"`, no intrinsic `width`/`height`.
- 24 CSS + 22 JS files load on every page regardless of what the page uses.

**Maintainability**
- The `en/` fork doubles every PHP change (§6).
- All 28 modules repeat the topbar/page-header/breadcrumb scaffold; ~12 repeat the sidebar list.
- `index.php`'s 640-line SEO `if/else` chain repeats near-identical meta blocks per route; it is
  data, not logic, and belongs in a lookup table.
- Bootstrap is pinned at `5.0.0-beta3` (a 2021 pre-release).
