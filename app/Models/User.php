<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class User extends Model
{
    /** @var string */
    protected $table = 'users';

    /** @var string[] */
    protected $sortable = ['id', 'name', 'username', 'email', 'last_login_at', 'created_at'];

    /**
     * @return array<string,mixed>|null
     */
    public function findByUsername(string $username): ?array
    {
        return $this->db()->selectOne(
            'SELECT u.*, r.slug AS role_slug, r.name AS role_name
               FROM users u
               JOIN roles r ON r.id = u.role_id
              WHERE u.username = ?
              LIMIT 1',
            [$username]
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findActive(int $id): ?array
    {
        return $this->db()->selectOne(
            'SELECT u.*, r.slug AS role_slug, r.name AS role_name
               FROM users u
               JOIN roles r ON r.id = u.role_id
              WHERE u.id = ? AND u.status = 1
              LIMIT 1',
            [$id]
        );
    }

    public function touchLogin(int $id): void
    {
        $this->db()->affected(
            'UPDATE users SET last_login_at = ? WHERE id = ?',
            [date('Y-m-d H:i:s'), $id]
        );
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->insert($data);
    }
}
