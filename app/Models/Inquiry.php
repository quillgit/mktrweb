<?php

namespace Mktr\Models;

use Mktr\Core\Model;

/**
 * Submissions from the public forms. Never rendered publicly — the admin inbox
 * is the only reader.
 */
class Inquiry extends Model
{
    /** @var string */
    protected $table = 'inquiries';

    /** @var string[] */
    protected $sortable = ['id', 'kind', 'status', 'created_at'];

    /** @var string[] */
    public static $kinds = ['contact', 'grievance', 'whistleblower'];

    /**
     * @param array<string,mixed> $payload form-specific fields
     */
    public function record(string $kind, array $fields, array $payload, string $ip, string $userAgent): int
    {
        return $this->insert([
            'kind'       => $kind,
            'name'       => isset($fields['name']) ? $fields['name'] : null,
            'email'      => isset($fields['email']) ? $fields['email'] : null,
            'phone'      => isset($fields['phone']) ? $fields['phone'] : null,
            'subject'    => isset($fields['subject']) ? $fields['subject'] : null,
            'message'    => isset($fields['message']) ? $fields['message'] : null,
            'payload'    => $payload === [] ? null : (string) json_encode($payload, JSON_UNESCAPED_UNICODE),
            'status'     => 'new',
            'ip'         => $ip,
            'user_agent' => mb_substr($userAgent, 0, 255),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function adminPage(int $limit, int $offset, string $kind = '', string $status = ''): array
    {
        $where    = ['1 = 1'];
        $bindings = [];

        if ($kind !== '') {
            $where[]    = 'kind = ?';
            $bindings[] = $kind;
        }

        if ($status !== '') {
            $where[]    = 'status = ?';
            $bindings[] = $status;
        }

        $bindings[] = $limit;
        $bindings[] = $offset;

        return $this->db()->select(
            'SELECT id, kind, name, email, phone, subject, status, created_at
               FROM inquiries
              WHERE ' . implode(' AND ', $where) . '
           ORDER BY created_at DESC, id DESC
              LIMIT ? OFFSET ?',
            $bindings
        );
    }

    public function adminCount(string $kind = '', string $status = ''): int
    {
        $where    = ['1 = 1'];
        $bindings = [];

        if ($kind !== '') {
            $where[]    = 'kind = ?';
            $bindings[] = $kind;
        }

        if ($status !== '') {
            $where[]    = 'status = ?';
            $bindings[] = $status;
        }

        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM inquiries WHERE ' . implode(' AND ', $where),
            $bindings
        );
    }

    public function countFromIpSince(string $ip, string $since): int
    {
        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM inquiries WHERE ip = ? AND created_at >= ?',
            [$ip, $since]
        );
    }

    public function markRead(int $id): void
    {
        $this->db()->affected("UPDATE inquiries SET status = 'read' WHERE id = ? AND status = 'new'", [$id]);
    }

    /**
     * Decoded payload for the detail view.
     *
     * @return array<string,mixed>
     */
    public function decodePayload(?string $payload): array
    {
        if ($payload === null || $payload === '') {
            return [];
        }

        $decoded = json_decode($payload, true);

        return is_array($decoded) ? $decoded : [];
    }
}
