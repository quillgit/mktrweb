<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class Revision extends Model
{
    /** @var string */
    protected $table = 'revisions';

    /** @var string[] */
    protected $sortable = ['id', 'created_at'];

    /**
     * @param array<string,mixed> $payload
     */
    public function record(string $type, int $id, array $payload, ?int $userId, string $note = ''): int
    {
        return $this->insert([
            'revisable_type' => $type,
            'revisable_id'   => $id,
            'payload'        => (string) json_encode($payload, JSON_UNESCAPED_UNICODE),
            'note'           => $note === '' ? null : $note,
            'created_by'     => $userId,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function forTarget(string $type, int $id, int $limit = 30): array
    {
        return $this->db()->select(
            'SELECT r.id, r.note, r.created_at, u.name AS author_name
               FROM revisions r
          LEFT JOIN users u ON u.id = r.created_by
              WHERE r.revisable_type = ? AND r.revisable_id = ?
           ORDER BY r.id DESC
              LIMIT ?',
            [$type, $id, $limit]
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function payload(int $revisionId, string $type, int $targetId): ?array
    {
        $row = $this->db()->selectOne(
            'SELECT payload FROM revisions
              WHERE id = ? AND revisable_type = ? AND revisable_id = ?
              LIMIT 1',
            [$revisionId, $type, $targetId]
        );

        if ($row === null) {
            return null;
        }

        $decoded = json_decode((string) $row['payload'], true);

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Keep history bounded so a heavily-edited post cannot grow without limit.
     */
    public function prune(string $type, int $id, int $keep = 30): void
    {
        $rows = $this->db()->select(
            'SELECT id FROM revisions
              WHERE revisable_type = ? AND revisable_id = ?
           ORDER BY id DESC
              LIMIT ? OFFSET ?',
            [$type, $id, 1000, $keep]
        );

        foreach ($rows as $row) {
            $this->delete((int) $row['id']);
        }
    }
}
