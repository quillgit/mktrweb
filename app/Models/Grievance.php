<?php

namespace Mktr\Models;

use Mktr\Core\Model;

/**
 * Public RSPO grievance register.
 *
 * The legacy page (module/keberlanjutan.php:545) publishes only laporan_date,
 * communication, organization, name and status, filtered to status = '2' AND
 * status_laporan <> 'laporan' — cases past the initial report stage. Email,
 * phone and address are stored but never rendered publicly, and that split is
 * preserved here: publicRegister() cannot return them.
 */
class Grievance extends Model
{
    /** @var string */
    protected $table = 'grievances';

    /** @var string[] */
    protected $sortable = ['id', 'reported_on', 'case_status', 'created_at'];

    /**
     * @return array<int,array<string,mixed>>
     */
    public function publicRegister(): array
    {
        return $this->db()->select(
            "SELECT id, reported_on, reporter_name, organization, communication, case_status
               FROM grievances
              WHERE status = 'published' AND case_status <> 'laporan'
           ORDER BY reported_on DESC, id DESC"
        );
    }

    /**
     * Record a submission from the public form.
     *
     * Matches the legacy handler exactly: the row lands unpublished with
     * case_status = 'laporan', so filing a grievance can never put anything on
     * the public register — somebody has to move the case forward first.
     *
     * @param array<string,string> $fields
     */
    public function record(array $fields, string $ip, string $userAgent): int
    {
        $now = date('Y-m-d H:i:s');

        return $this->insert([
            'reported_on'   => date('Y-m-d'),
            'reporter_name' => $fields['name'],
            'organization'  => $fields['organization'],
            'address'       => $fields['address'],
            'email'         => $fields['email'],
            'phone'         => $fields['phone'],
            'communication' => $fields['communication'],
            'case_status'   => 'laporan',
            'status'        => 'draft',
            'ip'            => $ip,
            'user_agent'    => mb_substr($userAgent, 0, 255),
            'submitted_at'  => $now,
            'created_at'    => $now,
        ]);
    }

    public function countFromIpSince(string $ip, string $since): int
    {
        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM grievances WHERE ip = ? AND created_at >= ?',
            [$ip, $since]
        );
    }

    /**
     * @return array<string,mixed>|null
     */
    public function findByLegacyRef(string $ref): ?array
    {
        return $this->db()->selectOne('SELECT * FROM grievances WHERE legacy_ref = ? LIMIT 1', [$ref]);
    }
}
