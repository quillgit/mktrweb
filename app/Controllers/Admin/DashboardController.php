<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Config;
use Mktr\Core\Response;
use Mktr\Models\Media;
use Mktr\Models\Post;

class DashboardController extends AdminController
{
    public function index(array $params): Response
    {
        $denied = $this->guard('content.view');
        if ($denied !== null) {
            return $denied;
        }

        $posts   = new Post();
        $default = (string) Config::get('app.default_locale', 'id');

        return $this->adminView('admin.dashboard', [
            'title'  => 'Dasbor — CMS MKTR',
            'counts' => [
                'published' => $posts->adminCount('published'),
                'scheduled' => $posts->adminCount('scheduled'),
                'draft'     => $posts->adminCount('draft'),
                'media'     => (new Media())->count(),
            ],
            'recent' => $posts->adminPage($default, 6, 0),
        ]);
    }
}
