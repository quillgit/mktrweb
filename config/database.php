<?php
/**
 * Database credentials.
 *
 * Read from the environment so production credentials are not committed. The
 * legacy configuration/connection.php has the live username and password in
 * the repository — those must be rotated before this goes live.
 */

$env = function (string $key, $default = null) {
    $value = getenv($key);

    return $value === false ? $default : $value;
};

return [
    'mysql' => [
        'host'     => (string) $env('DB_HOST', '127.0.0.1'),
        'port'     => (int) $env('DB_PORT', 3306),
        'database' => (string) $env('DB_DATABASE', 'mktr_v2'),
        'username' => (string) $env('DB_USERNAME', 'root'),
        'password' => (string) $env('DB_PASSWORD', ''),
        'charset'  => 'utf8mb4',

        // Set DB_SOCKET for local development against a unix socket.
        'socket'   => (string) $env('DB_SOCKET', ''),
    ],

    /*
     * Read-only connection to the legacy database, used by the importers in
     * database/import/. Left empty until a production dump is available.
     */
    'legacy' => [
        'host'     => (string) $env('LEGACY_DB_HOST', '127.0.0.1'),
        'port'     => (int) $env('LEGACY_DB_PORT', 3306),
        'database' => (string) $env('LEGACY_DB_DATABASE', 'mktr_legacy'),
        'username' => (string) $env('LEGACY_DB_USERNAME', 'root'),
        'password' => (string) $env('LEGACY_DB_PASSWORD', ''),
        'charset'  => 'utf8mb4',
        'socket'   => (string) $env('DB_SOCKET', ''),
    ],
];
