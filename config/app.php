<?php
/**
 * Application configuration.
 *
 * Values are read from the environment where one is available (cPanel can set
 * these via .htaccess SetEnv), with safe defaults for local development.
 */

$env = function (string $key, $default = null) {
    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    if ($value === 'true')  { return true; }
    if ($value === 'false') { return false; }

    return $value;
};

return [
    'name'  => 'PT Menthobi Karyatama Raya Tbk',

    // Never leave this on in production — it prints stack traces.
    'debug' => (bool) $env('APP_DEBUG', false),

    'url'   => (string) $env('APP_URL', 'https://mktr.co.id'),

    /*
     * Subdirectory the application is served from, without a trailing slash.
     * '/v2' while the rebuild runs alongside the legacy site; '' after cutover.
     */
    'base_path' => (string) $env('APP_BASE_PATH', '/v2'),

    /*
     * Prefix for static files, which is NOT base_path. assets/, images/ and
     * dokumen/ sit at the document root and are shared with the legacy site,
     * so they stay at /assets/... even while the application is served from
     * /v2 — and stay there unchanged after cutover. Media paths stored in the
     * database are already root-relative and follow the same rule.
     */
    'asset_base' => (string) $env('APP_ASSET_BASE', ''),

    /*
     * Signing key for session fingerprints and preview tokens.
     * MUST be overridden in production via the APP_KEY environment variable.
     */
    'key' => (string) $env('APP_KEY', 'mktr-local-development-key-change-me'),

    'timezone' => 'Asia/Jakarta',

    'session_name' => 'mktr_session',

    /*
     * Default locale is served from the root (/berita); every other locale is
     * prefixed (/en/berita). This is what replaced the en/ fork.
     */
    'default_locale' => 'id',
    'locales'        => ['id', 'en'],

    'locale_names' => [
        'id' => 'Indonesia',
        'en' => 'English',
    ],

    'per_page' => 9,

    'max_upload_bytes' => 10 * 1024 * 1024,

    'log_path' => BASE_DIR . '/storage/logs',

    'media' => [
        'storage_path'  => BASE_DIR . '/storage/uploads',
        'public_prefix' => '/storage/uploads',
    ],
];
