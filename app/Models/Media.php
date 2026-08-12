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

        if (!isset($data['kind'])) {
            $data['kind'] = isset($data['mime']) && $data['mime'] === 'application/pdf' ? 'document' : 'image';
        }

        return $this->insert($data);
    }

    /**
     * @param string $kind '' for everything, or 'image' / 'document'
     * @return array<int,array<string,mixed>>
     */
    public function paginate(int $limit, int $offset, string $search = '', string $kind = ''): array
    {
        list($where, $bindings) = $this->filter($search, $kind);

        $bindings[] = $limit;
        $bindings[] = $offset;

        return $this->db()->select(
            'SELECT * FROM media WHERE ' . $where . ' ORDER BY id DESC LIMIT ? OFFSET ?',
            $bindings
        );
    }

    public function countMatching(string $search = '', string $kind = ''): int
    {
        list($where, $bindings) = $this->filter($search, $kind);

        return (int) $this->db()->scalar('SELECT COUNT(*) FROM media WHERE ' . $where, $bindings);
    }

    /**
     * @return array{0:string,1:array<int,mixed>}
     */
    private function filter(string $search, string $kind): array
    {
        $where    = ['1 = 1'];
        $bindings = [];

        if ($search !== '') {
            $where[]    = '(filename LIKE ? OR alt LIKE ? OR title LIKE ?)';
            $term       = '%' . $search . '%';
            $bindings[] = $term;
            $bindings[] = $term;
            $bindings[] = $term;
        }

        if ($kind === 'image' || $kind === 'document') {
            $where[]    = 'kind = ?';
            $bindings[] = $kind;
        }

        return [implode(' AND ', $where), $bindings];
    }

    /**
     * Register a file that already exists in the repository (images/, dokumen/)
     * rather than one uploaded through the CMS. Marked external so deleting the
     * row never deletes the file.
     */
    public function registerExternal(array $data): int
    {
        $existing = $this->db()->selectOne('SELECT id FROM media WHERE path = ? LIMIT 1', [$data['path']]);

        if ($existing !== null) {
            return (int) $existing['id'];
        }

        $data['is_external'] = 1;
        $data['created_at']  = date('Y-m-d H:i:s');

        return $this->insert($data);
    }
}
