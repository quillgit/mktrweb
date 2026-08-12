<?php
/**
 * Base for the legacy importers.
 *
 * The legacy schema is only known from the queries in the old code, so the
 * importers never assume a column exists: each one introspects the source
 * table and selects the intersection of what it wants and what is actually
 * there. That is what lets the same code survive the real production dump,
 * where column names have drifted between tables.
 *
 * Every importer is idempotent. Rows carry a `legacy_ref` of the form
 * `<source table>:<source id>`, which is uniquely indexed, so a re-run updates
 * in place instead of duplicating.
 */

namespace Mktr\Import;

use Mktr\Core\Config;
use Mktr\Core\Database;
use PDO;

abstract class Importer
{
    /** @var PDO */
    protected $legacy;

    /** @var Database */
    protected $db;

    /** @var bool */
    protected $dryRun;

    /** @var array<string,array<string,int>> table => counters */
    protected $report = [];

    /** @var string[] */
    protected $notes = [];

    /** @var array<string,string[]> table => column names */
    private $columnCache = [];

    public function __construct(bool $dryRun = false)
    {
        $this->dryRun = $dryRun;
        $this->db     = Database::instance();
        $this->legacy = $this->connectLegacy();
    }

    abstract public function name(): string;

    abstract public function run(): void;

    private function connectLegacy(): PDO
    {
        $config = (array) Config::get('database.legacy', []);

        if (!empty($config['socket'])) {
            $dsn = sprintf(
                'mysql:unix_socket=%s;dbname=%s;charset=%s',
                $config['socket'],
                $config['database'],
                isset($config['charset']) ? $config['charset'] : 'utf8mb4'
            );
        } else {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $config['host'],
                isset($config['port']) ? (int) $config['port'] : 3306,
                $config['database'],
                isset($config['charset']) ? $config['charset'] : 'utf8mb4'
            );
        }

        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    /* ---- introspection --------------------------------------------------- */

    protected function tableExists(string $table): bool
    {
        $statement = $this->legacy->prepare(
            'SELECT COUNT(*) FROM information_schema.tables
              WHERE table_schema = DATABASE() AND table_name = ?'
        );
        $statement->execute([$table]);

        return (int) $statement->fetchColumn() > 0;
    }

    /**
     * @return string[]
     */
    protected function columns(string $table): array
    {
        if (isset($this->columnCache[$table])) {
            return $this->columnCache[$table];
        }

        $statement = $this->legacy->prepare(
            'SELECT column_name FROM information_schema.columns
              WHERE table_schema = DATABASE() AND table_name = ?'
        );
        $statement->execute([$table]);

        $columns = [];
        foreach ($statement->fetchAll() as $row) {
            // MariaDB and MySQL disagree on the case of this column name.
            $name      = isset($row['column_name']) ? $row['column_name'] : $row['COLUMN_NAME'];
            $columns[] = (string) $name;
        }

        $this->columnCache[$table] = $columns;

        return $columns;
    }

    /**
     * Pick the first column that actually exists, so the importer can cope with
     * `laporan_date` on one table and `created` on the next.
     */
    protected function firstColumn(string $table, array $candidates): ?string
    {
        $available = $this->columns($table);

        foreach ($candidates as $candidate) {
            if (in_array($candidate, $available, true)) {
                return $candidate;
            }
        }

        return null;
    }

    protected function hasColumn(string $table, string $column): bool
    {
        return in_array($column, $this->columns($table), true);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    protected function fetchAll(string $sql, array $bindings = []): array
    {
        $statement = $this->legacy->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetchAll();
    }

    /* ---- reporting -------------------------------------------------------- */

    protected function count(string $table, string $key, int $by = 1): void
    {
        if (!isset($this->report[$table])) {
            $this->report[$table] = ['source' => 0, 'imported' => 0, 'updated' => 0, 'skipped' => 0, 'missing_files' => 0];
        }

        $this->report[$table][$key] = (isset($this->report[$table][$key]) ? $this->report[$table][$key] : 0) + $by;
    }

    protected function note(string $message): void
    {
        $this->notes[] = $message;
    }

    public function report(): array
    {
        return $this->report;
    }

    /**
     * @return string[]
     */
    public function notes(): array
    {
        return $this->notes;
    }

    /* ---- helpers ---------------------------------------------------------- */

    /**
     * Register a file that already exists in the repository (images/, dokumen/)
     * as a media row. Files are never copied or moved; the row is flagged
     * external so deleting it can never unlink the source.
     *
     * @return int|null media id, or null when the path is empty
     */
    protected function registerFile(?string $filename, string $directory, string $kind, string $sourceTable): ?int
    {
        $filename = $filename === null ? '' : trim($filename);

        if ($filename === '') {
            return null;
        }

        // Legacy rows sometimes store a full path; keep only the basename.
        $filename = basename(str_replace('\\', '/', $filename));
        $path     = '/' . trim($directory, '/') . '/' . $filename;

        $existing = $this->db->selectOne('SELECT id FROM media WHERE path = ? LIMIT 1', [$path]);

        if ($existing !== null) {
            return (int) $existing['id'];
        }

        $absolute = BASE_DIR . $path;
        $onDisk   = is_file($absolute);

        if (!$onDisk) {
            $this->count($sourceTable, 'missing_files');
            $this->note(sprintf('%s: file referenced but missing on disk: %s', $sourceTable, $path));
        }

        if ($this->dryRun) {
            return null;
        }

        $size   = $onDisk ? (int) filesize($absolute) : 0;
        $width  = null;
        $height = null;
        $mime   = $kind === 'document' ? 'application/pdf' : 'image/jpeg';

        if ($onDisk && $kind === 'image') {
            $info = @getimagesize($absolute);
            if ($info !== false) {
                $width  = (int) $info[0];
                $height = (int) $info[1];
                $mime   = (string) $info['mime'];
            }
        }

        return $this->db->insert(
            'INSERT INTO media (path, filename, mime, kind, size, width, height, folder, is_external, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)',
            [$path, $filename, $mime, $kind, $size, $width, $height, 'legacy', date('Y-m-d H:i:s')]
        );
    }

    /**
     * The legacy sites used status = '2' to mean published; anything else was
     * a draft.
     */
    protected function mapStatus($legacyStatus): string
    {
        return (string) $legacyStatus === '2' ? 'published' : 'draft';
    }

    protected function normaliseDate($value): ?string
    {
        if ($value === null || $value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return null;
        }

        $timestamp = strtotime((string) $value);

        return $timestamp === false ? null : date('Y-m-d H:i:s', $timestamp);
    }
}
