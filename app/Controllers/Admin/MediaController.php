<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Config;
use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Uploader;
use Mktr\Models\Media;

class MediaController extends AdminController
{
    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $search = $this->request->text('q');
        $media  = new Media();
        $page   = max(1, $this->request->int('page', 1));

        $paginator = new Paginator(
            $media->countMatching($search),
            24,
            $page,
            $this->route('admin.media.index') . ($search !== '' ? '?q=' . rawurlencode($search) : '')
        );

        return $this->adminView('admin.media.index', [
            'title'     => 'Pustaka Media — CMS MKTR',
            'items'     => $media->paginate($paginator->perPage(), $paginator->offset(), $search),
            'paginator' => $paginator,
            'search'    => $search,
        ]);
    }

    public function store(array $params): Response
    {
        $denied = $this->guard('media.upload');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $file = $this->request->file('file');

        if ($file === null) {
            return $this->respond(false, 'Tidak ada berkas yang dipilih.', null);
        }

        $uploader = new Uploader(
            (string) Config::get('app.media.storage_path'),
            (string) Config::get('app.media.public_prefix')
        );

        try {
            $stored = $uploader->store($file, 'image');
        } catch (\RuntimeException $e) {
            return $this->respond(false, $e->getMessage(), null);
        }

        $media = new Media();
        $id    = $media->create([
            'path'        => $stored['path'],
            'filename'    => $stored['filename'],
            'mime'        => $stored['mime'],
            'size'        => $stored['size'],
            'width'       => $stored['width'],
            'height'      => $stored['height'],
            'alt'         => $this->request->text('alt'),
            'folder'      => date('Y/m'),
            'uploaded_by' => Auth::id(),
        ]);

        return $this->respond(true, 'Berkas berhasil diunggah.', $media->find($id));
    }

    public function destroy(array $params): Response
    {
        $denied = $this->guard('media.delete');
        if ($denied !== null) {
            return $denied;
        }

        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $media = new Media();
        $item  = $media->find((int) $params['id']);

        if ($item !== null) {
            /*
             * Only remove the file when it lives under the managed upload path.
             * Seeded rows point at pre-existing repository images, which must
             * not be deleted from disk.
             */
            $prefix = (string) Config::get('app.media.public_prefix');

            if (strpos((string) $item['path'], $prefix . '/') === 0) {
                $absolute = BASE_DIR . $item['path'];
                if (is_file($absolute)) {
                    @unlink($absolute);
                }
            }

            $media->delete((int) $item['id']);
        }

        Session::flash('success', 'Berkas berhasil dihapus.');

        return $this->redirect($this->route('admin.media.index'));
    }

    /**
     * JSON feed for the editor's media picker.
     */
    public function browse(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $media  = new Media();
        $search = $this->request->text('q');
        $page   = max(1, $this->request->int('page', 1));
        $limit  = 24;

        $items = $media->paginate($limit, ($page - 1) * $limit, $search);

        return Response::json([
            'items' => array_map(function (array $row) {
                return [
                    'id'       => (int) $row['id'],
                    'path'     => $row['path'],
                    'filename' => $row['filename'],
                    'alt'      => $row['alt'],
                    'width'    => $row['width'] !== null ? (int) $row['width'] : null,
                    'height'   => $row['height'] !== null ? (int) $row['height'] : null,
                ];
            }, $items),
            'total' => $media->countMatching($search),
        ]);
    }

    /**
     * Uploads arrive by fetch() from the media picker and by plain form post
     * from the library page; answer in whichever form the caller expects.
     */
    private function respond(bool $ok, string $message, ?array $item): Response
    {
        $wantsJson = strpos($this->request->server('HTTP_ACCEPT'), 'application/json') !== false
            || $this->request->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';

        if ($wantsJson) {
            return Response::json(
                ['ok' => $ok, 'message' => $message, 'item' => $item],
                $ok ? 200 : 422
            );
        }

        Session::flash($ok ? 'success' : 'error', $message);

        return $this->redirect($this->route('admin.media.index'));
    }
}
