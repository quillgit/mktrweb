<?php
/**
 * Legacy import CLI.
 *
 *   php database/import/run.php --dry-run          report without writing
 *   php database/import/run.php                    import everything
 *   php database/import/run.php --only=documents   one importer
 *
 * Reads the `legacy` connection from config/database.php. Safe to re-run:
 * every row is anchored by a unique legacy_ref, so a second pass updates
 * rather than duplicates.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

define('BASE_DIR', dirname(dirname(__DIR__)));

require BASE_DIR . '/app/bootstrap.php';

require __DIR__ . '/Importer.php';
require __DIR__ . '/DocumentsImporter.php';
require __DIR__ . '/PostsImporter.php';
require __DIR__ . '/PagesImporter.php';
require __DIR__ . '/JobsImporter.php';

use Mktr\Import\DocumentsImporter;
use Mktr\Import\JobsImporter;
use Mktr\Import\PagesImporter;
use Mktr\Import\PostsImporter;

$args   = array_slice($argv, 1);
$dryRun = in_array('--dry-run', $args, true);
$only   = '';

foreach ($args as $arg) {
    if (strpos($arg, '--only=') === 0) {
        $only = substr($arg, 7);
    }
}

$available = [
    'documents' => DocumentsImporter::class,
    'posts'     => PostsImporter::class,
    'pages'     => PagesImporter::class,
    'jobs'      => JobsImporter::class,
];

if ($only !== '' && !isset($available[$only])) {
    fwrite(STDERR, "Unknown importer: {$only}. Available: " . implode(', ', array_keys($available)) . "\n");
    exit(1);
}

$selected = $only !== '' ? [$only => $available[$only]] : $available;

echo $dryRun
    ? "DRY RUN — inspecting the legacy database, nothing will be written.\n\n"
    : "Importing from the legacy database.\n\n";

$grandTotals = ['source' => 0, 'imported' => 0, 'updated' => 0, 'skipped' => 0, 'missing_files' => 0];
$allNotes    = [];
$failed      = false;

foreach ($selected as $key => $class) {
    try {
        /** @var \Mktr\Import\Importer $importer */
        $importer = new $class($dryRun);
        $importer->run();
    } catch (\Throwable $e) {
        fwrite(STDERR, sprintf("[%s] FAILED: %s\n", $key, $e->getMessage()));
        $failed = true;
        continue;
    }

    $report = $importer->report();

    if ($report !== []) {
        printf("%s\n", strtoupper($key));
        printf("  %-38s %8s %9s %8s %8s %8s\n", 'source table', 'rows', 'imported', 'updated', 'skipped', 'no file');
        printf("  %s\n", str_repeat('-', 84));

        foreach ($report as $table => $counts) {
            printf(
                "  %-38s %8d %9d %8d %8d %8d\n",
                $table,
                $counts['source'],
                $counts['imported'],
                $counts['updated'],
                $counts['skipped'],
                $counts['missing_files']
            );

            foreach ($grandTotals as $metric => $_) {
                $grandTotals[$metric] += $counts[$metric];
            }
        }

        echo "\n";
    }

    $allNotes = array_merge($allNotes, $importer->notes());
}

/* ---- reconciliation ---------------------------------------------------- */

printf("RECONCILIATION\n");
printf("  source rows      %d\n", $grandTotals['source']);
printf("  imported         %d\n", $grandTotals['imported']);
printf("  updated          %d\n", $grandTotals['updated']);
printf("  skipped          %d\n", $grandTotals['skipped']);
printf("  missing files    %d\n", $grandTotals['missing_files']);

$accounted = $grandTotals['imported'] + $grandTotals['updated'] + $grandTotals['skipped'];
$balanced  = $accounted === $grandTotals['source'];

printf(
    "\n  %s  %d of %d source rows accounted for.\n",
    $balanced ? 'BALANCED  ' : 'UNBALANCED',
    $accounted,
    $grandTotals['source']
);

if ($allNotes !== []) {
    printf("\nNOTES (%d)\n", count($allNotes));

    // Long runs against production will produce many; cap the output.
    foreach (array_slice($allNotes, 0, 40) as $note) {
        printf("  - %s\n", $note);
    }

    if (count($allNotes) > 40) {
        printf("  … and %d more\n", count($allNotes) - 40);
    }
}

exit($failed || !$balanced ? 1 : 0);
