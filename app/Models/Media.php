<?php

namespace Mktr\Models;

use Mktr\Core\Model;

class Media extends Model
{
    /** @var string */
    protected $table = 'media';

    /** @var string[] */
    protected $sortable = ['id', 'filename', 'size', 'created_at'];

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->insert($data);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function paginate(int $limit, int $offset, string $search = ''): array
    {
        if ($search !== '') {
            return $this->db()->select(
                'SELECT * FROM media
                  WHERE filename LIKE ? OR alt LIKE ? OR title LIKE ?
                  ORDER BY id DESC
                  LIMIT ? OFFSET ?',
                ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%', $limit, $offset]
            );
        }

        return $this->db()->select(
            'SELECT * FROM media ORDER BY id DESC LIMIT ? OFFSET ?',
            [$limit, $offset]
        );
    }

    public function countMatching(string $search = ''): int
    {
        if ($search === '') {
            return $this->count();
        }

        return (int) $this->db()->scalar(
            'SELECT COUNT(*) FROM media WHERE filename LIKE ? OR alt LIKE ? OR title LIKE ?',
            ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%']
        );
    }
}
