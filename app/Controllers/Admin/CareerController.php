<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Config;
use Mktr\Core\Html;
use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Models\Job;
use Mktr\Models\Media;
use Mktr\Models\Revision;

class CareerController extends AdminController
{
    const REVISABLE = 'job';

    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $jobs      = new Job();
        $default   = (string) Config::get('app.default_locale', 'id');
        $paginator = new Paginator(
            $jobs->count(),
            20,
            max(1, $this->request->int('page', 1)),
            $this->route('admin.careers.index')
        );

        return $this->adminView('admin.careers.index', [
            'title'     => 'Karir — CMS MKTR',
            'rows'      => $jobs->adminPage($default, $paginator->perPage(), $paginator->offset()),
            'paginator' => $paginator,
        ]);
    }

    public function create(array $params): Response
    {
        $denied = $this->guard('content.create');
        if ($denied !== null) {
            return $denied;
        }

        return $this->adminView('admin.careers.form', [
            'title'        => 'Tambah Lowongan — CMS MKTR',
            'job'          => null,
            'translations' => [],
            'cover'        => null,
        ]);
    }

    public function edit(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $jobs = new Job();
        $job  = $jobs->find((int) $params['id']);

        if ($job === null) {
            return $this->notFound();
        }

        return $this->adminView('admin.careers.form', [
            'title'        => 'Sunting Lowongan — CMS MKTR',
            'job'          => $job,
            'translations' => $jobs->translations((int) $job['id']),
            'cover'        => $job['cover_media_id'] !== null
                ? (new Media())->find((int) $job['cover_media_id'])
                : null,
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

            return $this->redirect($this->route('admin.careers.create'));
        }

        $id = (new Job())->createWithTranslations($this->attributes($data, 0), $data['translations']);

        $this->snapshot($id, 'Dibuat');

        Session::flash('success', 'Lowongan berhasil disimpan.');

        return $this->redirect($this->route('admin.careers.edit', ['id' => $id]));
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

        $id   = (int) $params['id'];
        $jobs = new Job();

        if ($jobs->find($id) === null) {
            return $this->notFound();
        }

        $data      = $this->collect();
        $validator = new Validator($data['flat'], $this->labels());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.careers.edit', ['id' => $id]));
        }

        $this->snapshot($id, 'Sebelum penyuntingan');

        $jobs->updateWithTranslations($id, $this->attributes($data, $id), $data['translations']);

        (new Revision())->prune(self::REVISABLE, $id);

        Session::flash('success', 'Perubahan berhasil disimpan.');

        return $this->redirect($this->route('admin.careers.edit', ['id' => $id]));
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

        (new Job())->delete((int) $params['id']);

        Session::flash('success', 'Lowongan berhasil dihapus.');

        return $this->redirect($this->route('admin.careers.index'));
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

            $translations[$code] = [
                'slug'             => str_slug($this->request->text('slug_' . $code)),
                'title'            => $title,
                'body'             => Html::sanitize((string) $this->request->input('body_' . $code, '')),
                'meta_description' => $this->request->text('meta_description_' . $code),
            ];

            $flat['title_' . $code] = $title;
        }

        $flat['location']       = $this->request->text('location');
        $flat['closes_on']      = $this->request->text('closes_on');
        $flat['status']         = $this->request->text('status', 'draft');
        $flat['published_at']   = $this->request->text('published_at');
        $flat['cover_media_id'] = $this->request->int('cover_media_id', 0);
        $flat['slug']           = str_slug($this->request->text('slug'));
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
            'status'            => 'required|in:draft,scheduled,published',
            'published_at'      => 'nullable|date',
            'closes_on'         => 'nullable|date',
            'slug'              => 'nullable|slug|max:191',
        ];
    }

    /**
     * @return array<string,string>
     */
    private function labels(): array
    {
        return [
            'title_id'     => 'Judul (Indonesia)',
            'status'       => 'Status',
            'published_at' => 'Waktu publikasi',
            'closes_on'    => 'Tanggal penutupan',
            'slug'         => 'Slug',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function attributes(array $data, int $ignoreId): array
    {
        $flat    = $data['flat'];
        $default = (string) Config::get('app.default_locale', 'id');
        $jobs    = new Job();

        $slug = $flat['slug'] !== '' ? $flat['slug'] : str_slug((string) $flat['title_' . $default]);
        $slug = $jobs->uniqueSlug($slug, $ignoreId);

        $status      = (string) $flat['status'];
        $publishedAt = $flat['published_at'] !== ''
            ? date('Y-m-d H:i:s', (int) strtotime((string) $flat['published_at']))
            : null;

        if ($status === 'published' && $publishedAt === null) {
            $publishedAt = date('Y-m-d H:i:s');
        }

        if ($status === 'draft') {
            $publishedAt = null;
        }

        return [
            'slug'           => $slug,
            'location'       => $flat['location'] !== '' ? (string) $flat['location'] : null,
            'closes_on'      => $flat['closes_on'] !== ''
                ? date('Y-m-d', (int) strtotime((string) $flat['closes_on']))
                : null,
            'cover_media_id' => $flat['cover_media_id'] > 0 ? (int) $flat['cover_media_id'] : null,
            'status'         => $status,
            'published_at'   => $publishedAt,
        ];
    }

    private function snapshot(int $id, string $note): void
    {
        $jobs = new Job();
        $job  = $jobs->find($id);

        if ($job === null) {
            return;
        }

        (new Revision())->record(
            self::REVISABLE,
            $id,
            ['job' => $job, 'translations' => $jobs->translations($id)],
            Auth::id(),
            $note
        );
    }
}
