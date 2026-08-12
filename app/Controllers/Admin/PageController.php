<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Config;
use Mktr\Core\Html;
use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Models\DocumentCategory;
use Mktr\Models\Media;
use Mktr\Models\Page;
use Mktr\Models\Revision;

/**
 * Content pages: one screen for all six sections, replacing the seven legacy
 * adminpanel modules that each maintained their own table.
 */
class PageController extends AdminController
{
    const REVISABLE = 'page';

    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $pages   = new Page();
        $default = (string) Config::get('app.default_locale', 'id');

        $section = (string) $this->request->query('section', '');
        $status  = (string) $this->request->query('status', '');

        if (!in_array($section, Page::$sections, true)) {
            $section = '';
        }

        if (!in_array($status, ['', 'draft', 'scheduled', 'published'], true)) {
            $status = '';
        }

        $query = array_filter(['section' => $section ?: null, 'status' => $status ?: null]);
        $base  = $this->route('admin.pages.index') . ($query === [] ? '' : '?' . http_build_query($query));

        $paginator = new Paginator(
            $pages->adminCount($section, $status),
            30,
            max(1, $this->request->int('page', 1)),
            $base
        );

        $counts = ['all' => $pages->adminCount()];
        foreach (Page::$sections as $key) {
            $counts[$key] = $pages->adminCount($key);
        }

        return $this->adminView('admin.pages.index', [
            'title'     => 'Halaman — CMS MKTR',
            'rows'      => $pages->adminPage($default, $paginator->perPage(), $paginator->offset(), $section, $status),
            'paginator' => $paginator,
            'filters'   => ['section' => $section, 'status' => $status],
            'counts'    => $counts,
        ]);
    }

    public function create(array $params): Response
    {
        $denied = $this->guard('content.create');
        if ($denied !== null) {
            return $denied;
        }

        $default = (string) Config::get('app.default_locale', 'id');
        $section = (string) $this->request->query('section', 'about');
        $section = in_array($section, Page::$sections, true) ? $section : 'about';

        return $this->adminView('admin.pages.form', [
            'title'        => 'Tambah Halaman — CMS MKTR',
            'page'         => null,
            'translations' => [],
            'categories'   => (new DocumentCategory())->listing($default, $default),
            'parents'      => (new Page())->parentOptions($section, $default),
            'section'      => $section,
            'banner'       => null,
            'cover'        => null,
        ]);
    }

    public function edit(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $pages = new Page();
        $page  = $pages->find((int) $params['id']);

        if ($page === null) {
            return $this->notFound();
        }

        $default = (string) Config::get('app.default_locale', 'id');
        $media   = new Media();

        return $this->adminView('admin.pages.form', [
            'title'        => 'Sunting Halaman — CMS MKTR',
            'page'         => $page,
            'translations' => $pages->translations((int) $page['id']),
            'categories'   => (new DocumentCategory())->listing($default, $default),
            'parents'      => $pages->parentOptions((string) $page['section'], $default, (int) $page['id']),
            'section'      => (string) $page['section'],
            'banner'       => $page['banner_media_id'] !== null ? $media->find((int) $page['banner_media_id']) : null,
            'cover'        => $page['cover_media_id'] !== null ? $media->find((int) $page['cover_media_id']) : null,
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

            return $this->redirect($this->route('admin.pages.create') . '?section=' . urlencode((string) $data['flat']['section']));
        }

        $id = (new Page())->createWithTranslations($this->attributes($data, 0), $data['translations']);

        $this->snapshot($id, 'Dibuat');

        Session::flash('success', 'Halaman berhasil disimpan.');

        return $this->redirect($this->route('admin.pages.edit', ['id' => $id]));
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

        $id    = (int) $params['id'];
        $pages = new Page();

        if ($pages->find($id) === null) {
            return $this->notFound();
        }

        $data      = $this->collect();
        $validator = new Validator($data['flat'], $this->labels());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.pages.edit', ['id' => $id]));
        }

        $this->snapshot($id, 'Sebelum penyuntingan');

        $pages->updateWithTranslations($id, $this->attributes($data, $id), $data['translations']);

        (new Revision())->prune(self::REVISABLE, $id);

        Session::flash('success', 'Perubahan berhasil disimpan.');

        return $this->redirect($this->route('admin.pages.edit', ['id' => $id]));
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

        (new Page())->delete((int) $params['id']);

        Session::flash('success', 'Halaman berhasil dihapus.');

        return $this->redirect($this->route('admin.pages.index'));
    }

    /* ---- helpers --------------------------------------------------------- */

    /**
     * @return array{flat:array<string,mixed>,translations:array<string,array<string,mixed>>}
     */
    private function collect(): array
    {
        $locales      = (array) Config::get('app.locales', ['id']);
        $default      = (string) Config::get('app.default_locale', 'id');
        $translations = [];
        $flat         = [];

        foreach ($locales as $code) {
            $title = $this->request->text('title_' . $code);
            $body  = (string) $this->request->input('body_' . $code, '');

            $translations[$code] = [
                'slug'             => str_slug($this->request->text('slug_' . $code)),
                'title'            => $title,
                'subtitle'         => $this->request->text('subtitle_' . $code),
                'body'             => Html::sanitize($body),
                'meta_title'       => $this->request->text('meta_title_' . $code),
                'meta_description' => $this->request->text('meta_description_' . $code),
            ];

            $flat['title_' . $code] = $title;
            $flat['slug_' . $code]  = $translations[$code]['slug'];
        }

        $flat['section']              = $this->request->text('section', 'about');
        $flat['type']                 = $this->request->text('type', 'text');
        $flat['status']               = $this->request->text('status', 'draft');
        $flat['published_at']         = $this->request->text('published_at');
        $flat['parent_id']            = $this->request->int('parent_id', 0);
        $flat['document_category_id'] = $this->request->int('document_category_id', 0);
        $flat['sort']                 = $this->request->int('sort', 0);
        $flat['banner_media_id']      = $this->request->int('banner_media_id', 0);
        $flat['cover_media_id']       = $this->request->int('cover_media_id', 0);
        $flat['title']                = isset($flat['title_' . $default]) ? $flat['title_' . $default] : '';

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
            'section'           => 'required|in:' . implode(',', Page::$sections),
            'type'              => 'required|in:text,documents,grievances',
            'status'            => 'required|in:draft,scheduled,published',
            'published_at'      => 'nullable|date',
            'slug_' . $default  => 'nullable|slug|max:191',
        ];
    }

    /**
     * @return array<string,string>
     */
    private function labels(): array
    {
        return [
            'title_id'     => 'Judul (Indonesia)',
            'title_en'     => 'Judul (English)',
            'section'      => 'Bagian',
            'type'         => 'Tipe halaman',
            'status'       => 'Status',
            'published_at' => 'Waktu publikasi',
            'slug_id'      => 'Slug (Indonesia)',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function attributes(array $data, int $ignoreId): array
    {
        $flat    = $data['flat'];
        $default = (string) Config::get('app.default_locale', 'id');
        $pages   = new Page();

        $slug = $flat['slug_' . $default] !== ''
            ? $flat['slug_' . $default]
            : str_slug((string) $flat['title_' . $default]);

        $slug   = $pages->uniqueSlug((string) $flat['section'], $slug, $ignoreId);
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

        $type = (string) $flat['type'];

        return [
            'section'              => (string) $flat['section'],
            'parent_id'            => $flat['parent_id'] > 0 ? (int) $flat['parent_id'] : null,
            'type'                 => $type,
            'slug'                 => $slug,
            // Only a documents page carries a category; clearing it on the
            // others stops a stale pointer surviving a type change.
            'document_category_id' => $type === 'documents' && $flat['document_category_id'] > 0
                ? (int) $flat['document_category_id']
                : null,
            'banner_media_id'      => $flat['banner_media_id'] > 0 ? (int) $flat['banner_media_id'] : null,
            'cover_media_id'       => $flat['cover_media_id'] > 0 ? (int) $flat['cover_media_id'] : null,
            'sort'                 => (int) $flat['sort'],
            'status'               => $status,
            'published_at'         => $publishedAt,
        ];
    }

    private function snapshot(int $id, string $note): void
    {
        $pages = new Page();
        $page  = $pages->find($id);

        if ($page === null) {
            return;
        }

        (new Revision())->record(
            self::REVISABLE,
            $id,
            ['page' => $page, 'translations' => $pages->translations($id)],
            Auth::id(),
            $note
        );
    }
}
