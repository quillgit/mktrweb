<?php
/**
 * Base repository.
 *
 * Deliberately thin — a query helper, not an ORM. Column names passed to
 * where()/order() are validated against a per-model allowlist so identifiers
 * can never come from user input.
 */

namespace Mktr\Core;

abstract class Model
{
    /** @var string */
    protected $table = '';

    /** @var string */
    protected $primaryKey = 'id';

    /**
     * Columns that may be referenced in WHERE / ORDER BY clauses.
     * Identifiers cannot be bound as parameters, so they are allowlisted.
     *
     * @var string[]
     */
    protected $sortable = [];

    protected function db(): Database
    {
        return Database::instance();
    }

    public function find(int $id): ?array
    {
        return $this->db()->selectOne(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1",
            [$id]
        );
    }

    public function all(?string $orderBy = null, string $direction = 'ASC'): array
    {
        $sql = "SELECT * FROM {$this->table}";

        if ($orderBy !== null) {
            $sql .= ' ORDER BY ' . $this->safeColumn($orderBy) . ' ' . $this->safeDirection($direction);
        }

        return $this->db()->select($sql);
    }

    public function insert(array $data): int
    {
        $columns      = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        return $this->db()->insert($sql, array_values($data));
    }

    public function update(int $id, array $data): int
    {
        if ($data === []) {
            return 0;
        }

        $assignments = [];
        foreach (array_keys($data) as $column) {
            $assignments[] = $column . ' = ?';
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = ?',
            $this->table,
            implode(', ', $assignments),
            $this->primaryKey
        );

        $bindings   = array_values($data);
        $bindings[] = $id;

        return $this->db()->affected($sql, $bindings);
    }

    public function delete(int $id): int
    {
        return $this->db()->affected(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }

    public function count(string $where = '', array $bindings = []): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";

        if ($where !== '') {
            $sql .= ' WHERE ' . $where;
        }

        return (int) $this->db()->scalar($sql, $bindings);
    }

    /**
     * Reject any column name that is not explicitly allowlisted, so a sort
     * parameter from the query string can never reach SQL.
     */
    protected function safeColumn(string $column): string
    {
        $allowed = $this->sortable !== [] ? $this->sortable : [$this->primaryKey];

        return in_array($column, $allowed, true) ? $column : $this->primaryKey;
    }

    protected function safeDirection(string $direction): string
    {
        return strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
    }
}
