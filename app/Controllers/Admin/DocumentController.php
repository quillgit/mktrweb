<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Config;
use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Models\Document;
use Mktr\Models\DocumentCategory;
use Mktr\Models\Revision;

/**
 * One screen for all 19 document categories, replacing the 20 separate
 * adminpanel/modules/laporan_*.php files.
 */
class DocumentController extends AdminController
{
    const REVISABLE = 'document';

    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $documents  = new Document();
        $categories = new DocumentCategory();
        $default    = (string) Config::get('app.default_locale', 'id');

        $categoryId = $this->request->int('category', 0);
        $status     = (string) $this->request->query('status', '');
        $year       = $this->request->int('year', 0);

        if (!in_array($status, ['', 'draft', 'scheduled', 'published'], true)) {
            $status = '';
        }

        $year = $year > 0 ? $year : null;
        $page = max(1, $this->request->int('page', 1));

        $query = array_filter([
            'category' => $categoryId > 0 ? $categoryId : null,
            'status'   => $status !== '' ? $status : null,
            'year'     => $year,
        ]);

        $baseUrl = $this->route('admin.documents.index')
            . ($query === [] ? '' : '?' . http_build_query($query));

        $paginator = new Paginator(
            $documents->adminCount($categoryId, $status, $year),
            20,
            $page,
            $baseUrl
        );

        return $this->adminView('admin.documents.index', [
            'title'      => 'Dokumen Investor — CMS MKTR',
            'rows'       => $documents->adminPage($default, $paginator->perPage(), $paginator->offset(), $categoryId, $status, $year),
            'paginator'  => $paginator,
            'categories' => $categories->listing($default, $default),
            'years'      => $documents->allYears(),
            'filters'    => ['category' => $categoryId, 'status' => $status, 'year' => $year],
            'counts'     => [
                'all'       => $documents->adminCount(),
                'draft'     => $documents->adminCount(0, 'draft'),
                'scheduled' => $documents->adminCount(0, 'scheduled'),
                'published' => $documents->adminCount(0, 'published'),
            ],
        ]);
    }

    public function create(array $params): Response
    {
        $denied = $this->guard('content.create');
        if ($denied !== null) {
            return $denied;
        }

        $default = (string) Config::get('app.default_locale', 'id');

        return $this->adminView('admin.documents.form', [
            'title'        => 'Tambah Dokumen — CMS MKTR',
            'document'     => null,
            'translations' => [],
            'categories'   => (new DocumentCategory())->listing($default, $default),
            'file'         => null,
            'cover'        => null,
        ]);
    }

    public function edit(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $documents = new Document();
        $document  = $documents->find((int) $params['id']);

        if ($document === null) {
            return $this->notFound();
        }

        $media   = new \Mktr\Models\Media();
        $default = (string) Config::get('app.default_locale', 'id');

        return $this->adminView('admin.documents.form', [
            'title'        => 'Sunting Dokumen — CMS MKTR',
            'document'     => $document,
            'translations' => $documents->translations((int) $document['id']),
            'categories'   => (new DocumentCategory())->listing($default, $default),
            'file'         => $document['file_media_id'] !== null ? $media->find((int) $document['file_media_id']) : null,
            'cover'        => $document['cover_media_id'] !== null ? $media->find((int) $document['cover_media_id']) : null,
        ]);
    }

    public function store(array $params): Response
    {
        $denied = $this->guard('content.create');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $data      = $this->collect();
        $validator = new Validator($data['flat'], $this->labels());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.documents.create'));
        }

        $id = (new Document())->createWithTranslations($this->attributes($data), $data['translations']);

        $this->snapshot($id, 'Dibuat');

        Session::flash('success', 'Dokumen berhasil disimpan.');

        return $this->redirect($this->route('admin.documents.edit', ['id' => $id]));
    }

    public function update(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $id        = (int) $params['id'];
        $documents = new Document();

        if ($documents->find($id) === null) {
            return $this->notFound();
        }

        $data      = $this->collect();
        $validator = new Validator($data['flat'], $this->labels());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.documents.edit', ['id' => $id]));
        }

        // Snapshot before the write, so the revision restores the prior state.
        $this->snapshot($id, 'Sebelum penyuntingan');

        $documents->updateWithTranslations($id, $this->attributes($data), $data['translations']);

        (new Revision())->prune(self::REVISABLE, $id);

        Session::flash('success', 'Perubahan berhasil disimpan.');

        return $this->redirect($this->route('admin.documents.edit', ['id' => $id]));
    }

    public function destroy(array $params): Response
    {
        $denied = $this->guard('content.delete');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        (new Document())->delete((int) $params['id']);

        Session::flash('success', 'Dokumen berhasil dihapus.');

        return $this->redirect($this->route('admin.documents.index'));
    }

    /* ---- helpers --------------------------------------------------------- */

    /**
     * @return array{flat:array<string,mixed>,translations:array<string,array<string,string>>}
     */
    private function collect(): array
    {
        $locales      = (array) Config::get('app.locales', ['id']);
        $default      = (string) Config::get('app.default_locale', 'id');
        $translations = [];
        $flat         = [];

        foreach ($locales as $code) {
            $title = $this->request->text('title_' . $code);

            $translations[$code] = [
                'title'       => $title,
                'description' => $this->request->text('description_' . $code),
            ];

            $flat['title_' . $code]       = $title;
            $flat['description_' . $code] = $translations[$code]['description'];
        }

        $flat['category_id']    = $this->request->int('category_id', 0);
        $flat['status']         = $this->request->text('status', 'draft');
        $flat['published_at']   = $this->request->text('published_at');
        $flat['document_date']  = $this->request->text('document_date');
        $flat['sort']           = $this->request->int('sort', 0);
        $flat['file_media_id']  = $this->request->int('file_media_id', 0);
        $flat['cover_media_id'] = $this->request->int('cover_media_id', 0);
        $flat['title']          = isset($flat['title_' . $default]) ? $flat['title_' . $default] : '';

        return ['flat' => $flat, 'translations' => $translations];
    }

    /**
     * @return array<string,string>
     */
    private function rules(): array
    {
        $default = (string) Config::get('app.default_locale', 'id');

        return [
            'title_' . $default => 'required|max:255',
            'category_id'       => 'required|int',
            'status'            => 'required|in:draft,scheduled,published',
            'published_at'      => 'nullable|date',
            'document_date'     => 'nullable|date',
        ];
    }

    /**
     * @return array<string,string>
     */
    private function labels(): array
    {
        return [
            'title_id'      => 'Judul (Indonesia)',
            'title_en'      => 'Judul (English)',
            'category_id'   => 'Kategori',
            'status'        => 'Status',
            'published_at'  => 'Waktu publikasi',
            'document_date' => 'Tanggal dokumen',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function attributes(array $data): array
    {
        $flat   = $data['flat'];
        $status = (string) $flat['status'];

        $publishedAt = $flat['published_at'] !== ''
            ? date('Y-m-d H:i:s', (int) strtotime((string) $flat['published_at']))
            : null;

        if ($status === 'published' && $publishedAt === null) {
            $publishedAt = date('Y-m-d H:i:s');
        }

        if ($status === 'draft') {
            $publishedAt = null;
        }

        $documentDate = $flat['document_date'] !== ''
            ? date('Y-m-d', (int) strtotime((string) $flat['document_date']))
            : null;

        return [
            'category_id'    => (int) $flat['category_id'],
            'file_media_id'  => $flat['file_media_id'] > 0 ? (int) $flat['file_media_id'] : null,
            'cover_media_id' => $flat['cover_media_id'] > 0 ? (int) $flat['cover_media_id'] : null,
            'document_date'  => $documentDate,
            // Kept in step with document_date so the year filter is a plain index.
            'year'           => $documentDate !== null ? (int) date('Y', (int) strtotime($documentDate)) : null,
            'sort'           => (int) $flat['sort'],
            'status'         => $status,
            'published_at'   => $publishedAt,
        ];
    }

    private function snapshot(int $id, string $note): void
    {
        $documents = new Document();
        $document  = $documents->find($id);

        if ($document === null) {
            return;
        }

        (new Revision())->record(
            self::REVISABLE,
            $id,
            ['document' => $document, 'translations' => $documents->translations($id)],
            Auth::id(),
            $note
        );
    }
}
