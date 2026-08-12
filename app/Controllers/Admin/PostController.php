<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Config;
use Mktr\Core\Html;
use Mktr\Core\Paginator;
use Mktr\Core\PreviewToken;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Models\Media;
use Mktr\Models\Post;
use Mktr\Models\Revision;

class PostController extends AdminController
{
    const REVISABLE = 'post';

    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $status = (string) $this->request->query('status', '');
        if (!in_array($status, ['', 'draft', 'scheduled', 'published'], true)) {
            $status = '';
        }

        $posts   = new Post();
        $default = (string) Config::get('app.default_locale', 'id');
        $page    = max(1, $this->request->int('page', 1));

        $paginator = new Paginator(
            $posts->adminCount($status),
            20,
            $page,
            $this->route('admin.posts.index') . ($status !== '' ? '?status=' . $status : '')
        );

        return $this->adminView('admin.posts.index', [
            'title'     => 'Berita — CMS MKTR',
            'rows'      => $posts->adminPage($default, $paginator->perPage(), $paginator->offset(), $status),
            'paginator' => $paginator,
            'status'    => $status,
            'counts'    => [
                'all'       => $posts->adminCount(),
                'draft'     => $posts->adminCount('draft'),
                'scheduled' => $posts->adminCount('scheduled'),
                'published' => $posts->adminCount('published'),
            ],
        ]);
    }

    public function create(array $params): Response
    {
        $denied = $this->guard('content.create');
        if ($denied !== null) {
            return $denied;
        }

        return $this->adminView('admin.posts.form', [
            'title'        => 'Tulis Berita — CMS MKTR',
            'post'         => null,
            'translations' => [],
            'media'        => (new Media())->paginate(24, 0),
            'previewUrl'   => '',
        ]);
    }

    public function edit(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $posts = new Post();
        $post  = $posts->find((int) $params['id']);

        if ($post === null) {
            return $this->notFound();
        }

        return $this->adminView('admin.posts.form', [
            'title'        => 'Sunting Berita — CMS MKTR',
            'post'         => $post,
            'translations' => $posts->translations((int) $post['id']),
            'media'        => (new Media())->paginate(24, 0),
            'previewUrl'   => $this->route('preview.show', [
                'token' => PreviewToken::create(self::REVISABLE, (int) $post['id'], (string) Config::get('app.default_locale', 'id')),
            ]),
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

        $data = $this->collect();

        $validator = new Validator($data['flat'], $this->labels());
        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.posts.create'));
        }

        $posts  = new Post();
        $postId = $posts->createWithTranslations(
            $this->attributes($data, $posts, 0),
            $data['translations']
        );

        $this->snapshot($postId, 'Dibuat');

        Session::flash('success', 'Berita berhasil disimpan.');

        return $this->redirect($this->route('admin.posts.edit', ['id' => $postId]));
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

        $postId = (int) $params['id'];
        $posts  = new Post();

        if ($posts->find($postId) === null) {
            return $this->notFound();
        }

        $data      = $this->collect();
        $validator = new Validator($data['flat'], $this->labels());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.posts.edit', ['id' => $postId]));
        }

        // Snapshot the state BEFORE the write, so a revision restores what the
        // record looked like prior to this edit.
        $this->snapshot($postId, 'Sebelum penyuntingan');

        $posts->updateWithTranslations($postId, $this->attributes($data, $posts, $postId), $data['translations']);

        (new Revision())->prune(self::REVISABLE, $postId);

        Session::flash('success', 'Perubahan berhasil disimpan.');

        return $this->redirect($this->route('admin.posts.edit', ['id' => $postId]));
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

        (new Post())->delete((int) $params['id']);

        Session::flash('success', 'Berita berhasil dihapus.');

        return $this->redirect($this->route('admin.posts.index'));
    }

    public function revisions(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $postId = (int) $params['id'];
        $post   = (new Post())->find($postId);

        if ($post === null) {
            return $this->notFound();
        }

        return $this->adminView('admin.posts.revisions', [
            'title'     => 'Riwayat Revisi — CMS MKTR',
            'post'      => $post,
            'revisions' => (new Revision())->forTarget(self::REVISABLE, $postId),
        ]);
    }

    public function restore(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $postId     = (int) $params['id'];
        $revisionId = (int) $params['revision_id'];

        $payload = (new Revision())->payload($revisionId, self::REVISABLE, $postId);

        if ($payload === null || !isset($payload['post'], $payload['translations'])) {
            Session::flash('error', 'Revisi tidak ditemukan.');

            return $this->redirect($this->route('admin.posts.revisions', ['id' => $postId]));
        }

        // Snapshot the current state first, so a restore is itself undoable.
        $this->snapshot($postId, 'Sebelum pemulihan revisi');

        $post = $payload['post'];

        (new Post())->updateWithTranslations(
            $postId,
            [
                'category_id'    => $post['category_id'] !== null ? (int) $post['category_id'] : null,
                'cover_media_id' => $post['cover_media_id'] !== null ? (int) $post['cover_media_id'] : null,
                'slug'           => (string) $post['slug'],
                'status'         => (string) $post['status'],
                'published_at'   => $post['published_at'],
            ],
            $payload['translations']
        );

        Session::flash('success', 'Revisi berhasil dipulihkan.');

        return $this->redirect($this->route('admin.posts.edit', ['id' => $postId]));
    }

    /* ---- helpers --------------------------------------------------------- */

    /**
     * Gather submitted fields per locale plus a flattened copy for validation.
     *
     * @return array{flat:array<string,mixed>,translations:array<string,array<string,string>>,raw:array<string,mixed>}
     */
    private function collect(): array
    {
        $locales      = (array) Config::get('app.locales', ['id']);
        $default      = (string) Config::get('app.default_locale', 'id');
        $translations = [];
        $flat         = [];

        foreach ($locales as $code) {
            $title   = $this->request->text('title_' . $code);
            $excerpt = $this->request->text('excerpt_' . $code);
            $body    = (string) $this->request->input('body_' . $code, '');

            $translations[$code] = [
                'title'            => $title,
                'excerpt'          => $excerpt !== '' ? $excerpt : Html::excerpt($body),
                // Sanitised here, on the way in — templates print it raw.
                'body'             => Html::sanitize($body),
                'meta_title'       => $this->request->text('meta_title_' . $code),
                'meta_description' => $this->request->text('meta_description_' . $code),
            ];

            $flat['title_' . $code] = $title;
        }

        $flat['slug']         = $this->request->text('slug');
        $flat['status']       = $this->request->text('status', 'draft');
        $flat['published_at'] = $this->request->text('published_at');
        $flat['title']        = isset($flat['title_' . $default]) ? $flat['title_' . $default] : '';

        return ['flat' => $flat, 'translations' => $translations, 'raw' => $this->request->all()];
    }

    /**
     * @return array<string,string>
     */
    private function rules(): array
    {
        $default = (string) Config::get('app.default_locale', 'id');

        return [
            'title_' . $default => 'required|max:255',
            'slug'              => 'nullable|slug|max:191',
            'status'            => 'required|in:draft,scheduled,published',
            'published_at'      => 'nullable|date',
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
            'slug'         => 'Slug',
            'status'       => 'Status',
            'published_at' => 'Waktu publikasi',
        ];
    }

    /**
     * Build the posts-table row from submitted data.
     *
     * @return array<string,mixed>
     */
    private function attributes(array $data, Post $posts, int $ignoreId): array
    {
        $default = (string) Config::get('app.default_locale', 'id');
        $flat    = $data['flat'];

        $slug = $flat['slug'] !== '' ? str_slug($flat['slug']) : str_slug((string) $flat['title_' . $default]);
        $slug = $posts->uniqueSlug($slug, $ignoreId);

        $status      = (string) $flat['status'];
        $publishedAt = $flat['published_at'] !== ''
            ? date('Y-m-d H:i:s', (int) strtotime((string) $flat['published_at']))
            : null;

        // Publishing without an explicit time means "now".
        if ($status === 'published' && $publishedAt === null) {
            $publishedAt = date('Y-m-d H:i:s');
        }

        // A draft has no go-live time at all.
        if ($status === 'draft') {
            $publishedAt = null;
        }

        $coverId = $this->request->int('cover_media_id', 0);

        $attributes = [
            'slug'           => $slug,
            'status'         => $status,
            'published_at'   => $publishedAt,
            'cover_media_id' => $coverId > 0 ? $coverId : null,
        ];

        if ($ignoreId === 0) {
            $attributes['author_id']   = Auth::id();
            $attributes['category_id'] = 1;
        }

        return $attributes;
    }

    /**
     * Persist a snapshot of the record and every translation.
     */
    private function snapshot(int $postId, string $note): void
    {
        $posts = new Post();
        $post  = $posts->find($postId);

        if ($post === null) {
            return;
        }

        (new Revision())->record(
            self::REVISABLE,
            $postId,
            ['post' => $post, 'translations' => $posts->translations($postId)],
            Auth::id(),
            $note
        );
    }
}
