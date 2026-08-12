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
     * @return array<string,mixed>|null
     */
    public function findByLegacyRef(string $ref): ?array
    {
        return $this->db()->selectOne('SELECT * FROM grievances WHERE legacy_ref = ? LIMIT 1', [$ref]);
    }
}
