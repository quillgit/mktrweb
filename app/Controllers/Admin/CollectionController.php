<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Config;
use Mktr\Core\Html;
use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Models\CollectionItem;
use Mktr\Models\Media;

/**
 * One editor for the six small collections. `kind` picks the collection; the
 * fields that only some kinds use (the leadership board, the outbound link,
 * the mobile banner) are shown per kind rather than being six near-identical
 * screens.
 */
class CollectionController extends AdminController
{
    /** kind => [singular label, plural label]. */
    private static $labels = [
        'leadership'  => ['Manajemen', 'Manajemen'],
        'subsidiary'  => ['Anak Perusahaan', 'Anak Perusahaan'],
        'award'       => ['Penghargaan', 'Penghargaan & Pengakuan'],
        'membership'  => ['Keanggotaan', 'Keanggotaan'],
        'milestone'   => ['Peristiwa', 'Peristiwa Penting'],
        'banner'      => ['Banner', 'Banner Beranda'],
    ];

    /** Boards available to `leadership`; other kinds have no groups. */
    private static $groups = [
        'dewan_komisaris' => 'Dewan Komisaris',
        'dewan_direksi'   => 'Dewan Direksi',
    ];

    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $items   = new CollectionItem();
        $kind    = $this->kindFilter();
        $default = (string) Config::get('app.default_locale', 'id');

        $paginator = new Paginator(
            $items->adminCount($kind),
            30,
            max(1, $this->request->int('page', 1)),
            $this->route('admin.collections.index') . ($kind !== '' ? '?kind=' . $kind : '')
        );

        return $this->adminView('admin.collections.index', [
            'title'     => 'Koleksi — CMS MKTR',
            'rows'      => $items->adminPage($default, $paginator->perPage(), $paginator->offset(), $kind),
            'paginator' => $paginator,
            'kind'      => $kind,
            'labels'    => self::$labels,
            'groups'    => self::$groups,
        ]);
    }

    public function create(array $params): Response
    {
        $denied = $this->guard('content.create');
        if ($denied !== null) {
            return $denied;
        }

        $kind = $this->kindFilter();

        return $this->adminView('admin.collections.form', $this->formData(null, $kind !== '' ? $kind : 'leadership'));
    }

    public function edit(array $params): Response
    {
        $denied = $this->guard('content.edit');
        if ($denied !== null) {
            return $denied;
        }

        $items = new CollectionItem();
        $item  = $items->find((int) $params['id']);

        if ($item === null) {
            return $this->notFound();
        }

        return $this->adminView('admin.collections.form', $this->formData($item, (string) $item['kind']));
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
        $validator = new Validator($data['flat'], $this->labelsForValidation());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.collections.create') . '?kind=' . $data['flat']['kind']);
        }

        $id = (new CollectionItem())->createWithTranslations(
            $this->attributes($data, 0),
            $data['translations']
        );

        Session::flash('success', 'Data berhasil disimpan.');

        return $this->redirect($this->route('admin.collections.edit', ['id' => $id]));
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

        $id       = (int) $params['id'];
        $items    = new CollectionItem();
        $existing = $items->find($id);

        if ($existing === null) {
            return $this->notFound();
        }

        $data      = $this->collect();
        $validator = new Validator($data['flat'], $this->labelsForValidation());

        if (!$validator->validate($this->rules())) {
            $this->withErrors($validator->firstErrors(), $data['flat']);

            return $this->redirect($this->route('admin.collections.edit', ['id' => $id]));
        }

        $items->updateWithTranslations($id, $this->attributes($data, $id, $existing), $data['translations']);

        Session::flash('success', 'Perubahan berhasil disimpan.');

        return $this->redirect($this->route('admin.collections.edit', ['id' => $id]));
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

        (new CollectionItem())->delete((int) $params['id']);

        Session::flash('success', 'Data berhasil dihapus.');

        return $this->redirect($this->route('admin.collections.index'));
    }

    /* ---- helpers --------------------------------------------------------- */

    private function kindFilter(): string
    {
        $kind = $this->request->text('kind');

        return isset(self::$labels[$kind]) ? $kind : '';
    }

    /**
     * @param  array<string,mixed>|null $item
     * @return array<string,mixed>
     */
    private function formData(?array $item, string $kind): array
    {
        $items = new CollectionItem();
        $media = new Media();

        $pick = function ($id) use ($media) {
            return $id !== null && $id !== '' ? $media->find((int) $id) : null;
        };

        return [
            'title'        => ($item === null ? 'Tambah ' : 'Sunting ') . self::$labels[$kind][0] . ' — CMS MKTR',
            'item'         => $item,
            'kind'         => $kind,
            'labels'       => self::$labels,
            'groups'       => self::$groups,
            'translations' => $item !== null ? $items->translations((int) $item['id']) : [],
            'image'        => $item !== null ? $pick($item['image_media_id']) : null,
            'detailImage'  => $item !== null ? $pick($item['detail_image_media_id']) : null,
            'mobileImage'  => $item !== null ? $pick($item['mobile_image_media_id']) : null,
        ];
    }

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
                'title'    => $title,
                'subtitle' => $this->request->text('subtitle_' . $code),
                'body'     => Html::sanitize((string) $this->request->input('body_' . $code, '')),
            ];

            $flat['title_' . $code] = $title;
        }

        $kind = $this->request->text('kind');

        $flat['kind']                  = isset(self::$labels[$kind]) ? $kind : 'leadership';
        $flat['group_key']             = $this->request->text('group_key');
        $flat['slug']                  = str_slug($this->request->text('slug'));
        $flat['link']                  = $this->request->text('link');
        $flat['sort']                  = $this->request->int('sort', 0);
        $flat['status']                = $this->request->text('status', 'draft');
        $flat['image_media_id']        = $this->request->int('image_media_id', 0);
        $flat['detail_image_media_id'] = $this->request->int('detail_image_media_id', 0);
        $flat['mobile_image_media_id'] = $this->request->int('mobile_image_media_id', 0);
        $flat['title']                 = isset($flat['title_' . $default]) ? $flat['title_' . $default] : '';

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
            'kind'              => 'required|in:' . implode(',', CollectionItem::$kinds),
            'status'            => 'required|in:draft,published',
            'slug'              => 'nullable|slug|max:191',
            'link'              => 'nullable|max:500',
        ];
    }

    /**
     * @return array<string,string>
     */
    private function labelsForValidation(): array
    {
        return [
            'title_id' => 'Judul (Indonesia)',
            'kind'     => 'Jenis',
            'status'   => 'Status',
            'slug'     => 'Slug',
            'link'     => 'Tautan',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function attributes(array $data, int $ignoreId, ?array $existing = null): array
    {
        $flat    = $data['flat'];
        $default = (string) Config::get('app.default_locale', 'id');
        $items   = new CollectionItem();

        $kind = (string) $flat['kind'];
        $slug = $flat['slug'] !== '' ? $flat['slug'] : str_slug((string) $flat['title_' . $default]);
        $slug = $items->uniqueSlug($kind, $slug, $ignoreId);

        $status = $flat['status'] === 'published' ? 'published' : 'draft';

        /* Keep the original publication time; only stamp it the first time. */
        $publishedAt = null;
        if ($status === 'published') {
            $publishedAt = $existing !== null && !empty($existing['published_at'])
                ? (string) $existing['published_at']
                : date('Y-m-d H:i:s');
        }

        return [
            'kind'                  => $kind,
            // Only leadership is grouped; a stray group on another kind would
            // silently hide the row from its own listing.
            'group_key'             => $kind === 'leadership' && isset(self::$groups[$flat['group_key']])
                ? (string) $flat['group_key']
                : null,
            'slug'                  => $slug,
            'link'                  => $flat['link'] !== '' ? (string) $flat['link'] : null,
            'sort'                  => (int) $flat['sort'],
            'status'                => $status,
            'published_at'          => $publishedAt,
            'image_media_id'        => $flat['image_media_id'] > 0 ? (int) $flat['image_media_id'] : null,
            'detail_image_media_id' => $flat['detail_image_media_id'] > 0 ? (int) $flat['detail_image_media_id'] : null,
            'mobile_image_media_id' => $flat['mobile_image_media_id'] > 0 ? (int) $flat['mobile_image_media_id'] : null,
        ];
    }
}
