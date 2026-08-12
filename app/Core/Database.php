<?php
/**
 * PDO wrapper.
 *
 * Every query in the rebuilt application goes through here with bound
 * parameters. The legacy site used mysql_* with values interpolated straight
 * into SQL strings; that is what this replaces.
 */

namespace Mktr\Core;

use PDO;
use PDOStatement;

class Database
{
    /** @var self|null */
    private static $instance;

    /** @var PDO */
    private $pdo;

    private function __construct(array $config)
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            isset($config['port']) ? (int) $config['port'] : 3306,
            $config['database'],
            isset($config['charset']) ? $config['charset'] : 'utf8mb4'
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Real prepared statements, not client-side interpolation.
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        if (!empty($config['socket'])) {
            $dsn = sprintf(
                'mysql:unix_socket=%s;dbname=%s;charset=%s',
                $config['socket'],
                $config['database'],
                isset($config['charset']) ? $config['charset'] : 'utf8mb4'
            );
        }

        $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);

        $this->alignTimezone();
    }

    /**
     * Align the MySQL session timezone with PHP's.
     *
     * Timestamps are written by PHP (date('Y-m-d H:i:s') in Asia/Jakarta) but
     * compared against the server's NOW() — e.g. the publishing check
     * `published_at <= NOW()`. On a server running UTC that is a 7-hour
     * discrepancy, so a post published "now" would stay invisible for the rest
     * of the day. A numeric offset is used because the named-timezone tables
     * are frequently not loaded on shared hosting.
     */
    private function alignTimezone(): void
    {
        try {
            $timezone = new \DateTimeZone((string) Config::get('app.timezone', 'Asia/Jakarta'));
            $offset   = $timezone->getOffset(new \DateTime('now', $timezone));

            $sign    = $offset < 0 ? '-' : '+';
            $offset  = abs($offset);
            $literal = sprintf('%s%02d:%02d', $sign, intdiv($offset, 3600), intdiv($offset % 3600, 60));

            $this->pdo->exec("SET time_zone = '" . $literal . "'");
        } catch (\Throwable $e) {
            // A server that refuses the offset keeps its default; the app still
            // runs, and the mismatch surfaces in the scheduling tests.
        }
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            $config = Config::get('database.mysql', []);
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    public function run(string $sql, array $bindings = []): PDOStatement
    {
        $statement = $this->pdo->prepare($sql);

        /*
         * Bind by type rather than passing the array to execute(), which would
         * send every value as a string. With emulated prepares disabled, MySQL
         * rejects a quoted value in LIMIT/OFFSET, so integers must be bound as
         * PDO::PARAM_INT.
         */
        foreach ($bindings as $key => $value) {
            $parameter = is_int($key) ? $key + 1 : $key;

            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif ($value === null) {
                $type = PDO::PARAM_NULL;
            } else {
                $type = PDO::PARAM_STR;
            }

            $statement->bindValue($parameter, $value, $type);
        }

        $statement->execute();

        return $statement;
    }

    public function select(string $sql, array $bindings = []): array
    {
        return $this->run($sql, $bindings)->fetchAll();
    }

    /**
     * @return array<string,mixed>|null
     */
    public function selectOne(string $sql, array $bindings = []): ?array
    {
        $row = $this->run($sql, $bindings)->fetch();

        return $row === false ? null : $row;
    }

    /**
     * @return mixed
     */
    public function scalar(string $sql, array $bindings = [])
    {
        return $this->run($sql, $bindings)->fetchColumn();
    }

    public function insert(string $sql, array $bindings = []): int
    {
        $this->run($sql, $bindings);

        return (int) $this->pdo->lastInsertId();
    }

    public function affected(string $sql, array $bindings = []): int
    {
        return $this->run($sql, $bindings)->rowCount();
    }

    public function transaction(callable $callback)
    {
        $this->pdo->beginTransaction();

        try {
            $result = $callback($this);
            $this->pdo->commit();

            return $result;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
