<?php
/**
 * Migration CLI.
 *
 *   php database/migrate.php            apply pending migrations
 *   php database/migrate.php --status   list applied / pending
 *   php database/migrate.php --seed     apply, then seed development data
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

define('BASE_DIR', dirname(__DIR__));

require BASE_DIR . '/app/bootstrap.php';

use Mktr\Core\Database;
use Mktr\Core\Migrator;

$args   = array_slice($argv, 1);
$status = in_array('--status', $args, true);
$seed   = in_array('--seed', $args, true);

try {
    $migrator = new Migrator(BASE_DIR . '/database/migrations');

    if ($status) {
        $applied = $migrator->applied();
        $files   = array_map('basename', (array) glob(BASE_DIR . '/database/migrations/*.sql'));
        sort($files, SORT_STRING);

        foreach ($files as $file) {
            printf("%-8s %s\n", in_array($file, $applied, true) ? 'applied' : 'pending', $file);
        }

        exit(0);
    }

    $ran = $migrator->run();

    if ($ran === []) {
        echo "Nothing to migrate.\n";
    } else {
        foreach ($ran as $name) {
            echo "migrated  " . $name . "\n";
        }
    }

    if ($seed) {
        $seeder = BASE_DIR . '/database/seed.php';

        if (is_file($seeder)) {
            require $seeder;
            echo "seeded    development data\n";
        }
    }

    exit(0);
} catch (\Throwable $e) {
    fwrite(STDERR, get_class($e) . ': ' . $e->getMessage() . "\n");
    exit(1);
}
