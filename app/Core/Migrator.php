<?php
/**
 * Forward-only migration runner.
 *
 * Files in database/migrations/ are named NNN_description.sql and applied in
 * order. Applied names are recorded so re-running is a no-op.
 */

namespace Mktr\Core;

class Migrator
{
    /** @var string */
    private $path;

    /** @var Database */
    private $db;

    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/');
        $this->db   = Database::instance();
    }

    private function ensureTable(): void
    {
        $this->db->run(
            'CREATE TABLE IF NOT EXISTS migrations (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                migration VARCHAR(191) NOT NULL,
                applied_at DATETIME NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY uniq_migration (migration)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );
    }

    /**
     * @return string[] names applied during this run
     */
    public function run(): array
    {
        $this->ensureTable();

        $applied = $this->applied();
        $files   = glob($this->path . '/*.sql');
        sort($files, SORT_STRING);

        $ran = [];

        foreach ($files as $file) {
            $name = basename($file);

            if (in_array($name, $applied, true)) {
                continue;
            }

            $sql = (string) file_get_contents($file);

            foreach ($this->splitStatements($sql) as $statement) {
                $this->db->run($statement);
            }

            $this->db->run(
                'INSERT INTO migrations (migration, applied_at) VALUES (?, ?)',
                [$name, date('Y-m-d H:i:s')]
            );

            $ran[] = $name;
        }

        return $ran;
    }

    /**
     * @return string[]
     */
    public function applied(): array
    {
        $this->ensureTable();

        $rows = $this->db->select('SELECT migration FROM migrations ORDER BY id ASC');

        return array_map(function (array $row) {
            return (string) $row['migration'];
        }, $rows);
    }

    /**
     * Split on semicolons at end of line, ignoring those inside strings and
     * `-- ` comments.
     *
     * @return string[]
     */
    private function splitStatements(string $sql): array
    {
        $lines      = preg_split('/\R/', $sql);
        $statements = [];
        $buffer     = '';

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '' || strpos($trimmed, '--') === 0) {
                continue;
            }

            $buffer .= $line . "\n";

            if (substr($trimmed, -1) === ';') {
                $statement = trim($buffer);
                $statement = rtrim($statement, ';');

                if ($statement !== '') {
                    $statements[] = $statement;
                }

                $buffer = '';
            }
        }

        $remaining = trim($buffer);
        if ($remaining !== '') {
            $statements[] = rtrim($remaining, ';');
        }

        return $statements;
    }
}
