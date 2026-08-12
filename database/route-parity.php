<?php
/**
 * Route parity check.
 *
 * Walks every URL pattern the legacy .htaccess rewrites (SPEC.md §4) and asks
 * the rebuilt application for it, in both locales. Slug and id patterns are
 * filled from the imported database rather than invented, so a 404 here means
 * a route is genuinely missing — not that the fixture happened to be empty.
 *
 *   php database/route-parity.php http://127.0.0.1:8099/v2
 *
 * Exits non-zero if anything is missing, so it can gate a cutover.
 */

declare(strict_types=1);

define('BASE_DIR', dirname(__DIR__));

/** @var \Mktr\Core\App $app */
$app = require BASE_DIR . '/app/bootstrap.php';

use Mktr\Core\Config;
use Mktr\Core\Database;

$base = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://127.0.0.1:8099/v2';
$db   = Database::instance();

$one = function (string $sql) use ($db) {
    $row = $db->selectOne($sql);

    return $row === null ? null : (string) reset($row);
};

$pageSlug = function (string $section) use ($db) {
    $row = $db->selectOne(
        "SELECT COALESCE(t.slug, p.slug) AS slug
           FROM pages p
      LEFT JOIN page_translations t ON t.page_id = p.id AND t.locale = 'id'
          WHERE p.section = ? AND p.status = 'published' AND p.published_at <= NOW()
          LIMIT 1",
        [$section]
    );

    return $row === null ? null : (string) $row['slug'];
};

$post = $db->selectOne("SELECT id, slug FROM posts WHERE status = 'published' AND published_at <= NOW() LIMIT 1");
$job  = $db->selectOne("SELECT id, slug FROM jobs WHERE status = 'published' AND published_at <= NOW() LIMIT 1");
$doc  = $db->selectOne("SELECT id FROM documents WHERE status = 'published' AND published_at <= NOW() LIMIT 1");
$so   = $one("SELECT slug FROM collection_items WHERE kind = 'leadership' AND status = 'published' LIMIT 1");

/*
 * Legacy path => expected status. Anything a real visitor could type, in the
 * order the .htaccess lists them.
 */
$routes = [
    '/'                                                   => 200,
    '/profil_kami'                                        => 200,
    '/logo_kami'                                          => 200,
    '/visi_misi'                                          => 200,
    '/peristiwa_penting'                                  => 200,
    '/struktur_kepemilikan'                               => 200,
    '/struktur_organisasi'                                => 200,
    '/dewan_komisaris'                                    => 200,
    '/direksi'                                            => 200,
    '/struktur_group'                                     => 200,
    '/anak_perusahaan_kami'                               => 200,
    '/penghargaan'                                        => 200,
    '/keanggotaan'                                        => 200,
    '/berita'                                             => 200,
    '/berita/1'                                           => 200,
    '/karir'                                              => 200,
    '/kontak_kami'                                        => 200,
    '/form_grievance'                                     => 200,
    '/pelaporan_pelanggaran'                              => 200,
    '/keberlanjutan/daftar-pengaduan'                     => 200,
];

if ($so !== null)   { $routes['/mktr_so/' . $so] = 200; }
if ($post !== null) { $routes['/read/' . $post['id'] . '/' . $post['slug']] = 200; }
if ($job !== null)  { $routes['/apply/' . $job['id'] . '/' . $job['slug']] = 200; }
if ($doc !== null)  { $routes['/dokumen/' . $doc['id'] . '/laporan'] = 200; }

foreach (['business' => '/bisnis', 'sustainability' => '/keberlanjutan',
          'governance' => '/tatakelola_perusahaan', 'hr' => '/sdm',
          'investor' => '/hubungan_investor'] as $section => $prefix) {
    $slug = $pageSlug($section);

    if ($slug !== null) {
        $routes[$prefix . '/' . $slug] = 200;
    } else {
        fwrite(STDERR, "WARNING: no published page in section {$section}; pattern {$prefix}/{slug} not exercised\n");
    }
}

$routes['/cari/kelapa-sawit'] = 200;
// Unknown slugs must 404 rather than redirecting to the home page, which is
// what the legacy `echo "<script>window.location=..."` did.
$routes['/bisnis/tidak-ada-halaman-ini'] = 404;
$routes['/mktr_so/tidak-ada-orang-ini']  = 404;
$routes['/halaman-yang-tidak-ada']       = 404;

$locales = (array) Config::get('app.locales', ['id']);
$default = (string) Config::get('app.default_locale', 'id');

$failures = 0;
$checked  = 0;

printf("%-6s %-46s %s\n", 'STATUS', 'URL', 'EXPECTED');
echo str_repeat('-', 76) . "\n";

foreach ($locales as $locale) {
    $prefix = $locale === $default ? '' : '/' . $locale;

    foreach ($routes as $path => $expected) {
        $url = $base . $prefix . ($path === '/' ? '/' : $path);

        $handle = curl_init($url);
        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_NOBODY         => false,
        ]);
        curl_exec($handle);
        $status = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        $checked++;
        $ok = $status === $expected;

        if (!$ok) {
            $failures++;
        }

        printf("%-6s %-46s %s\n", ($ok ? 'ok' : 'FAIL') . ' ' . $status, $prefix . $path, $expected);
    }
}

echo str_repeat('-', 76) . "\n";
printf("%d URLs checked, %d failures\n", $checked, $failures);

exit($failures === 0 ? 0 : 1);
