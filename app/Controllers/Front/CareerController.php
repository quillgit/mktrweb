<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Html;
use Mktr\Core\Response;
use Mktr\Models\Job;

class CareerController extends Controller
{
    public function index(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');

        return $this->view('front.careers.index', [
            'jobs'            => (new Job())->open($locale, $fallback),
            'title'           => __('careers.title') . ' — ' . __('site.name'),
            'metaDescription' => __('careers.subtitle'),
            'canonical'       => $this->route('careers.index'),
        ]);
    }

    public function show(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $id       = isset($params['id']) ? (int) $params['id'] : 0;

        $jobs = new Job();
        $job  = $jobs->findPublished($id, $locale, $fallback);

        if ($job === null) {
            return $this->notFound();
        }

        return $this->view('front.careers.show', [
            'job'             => $job,
            'title'           => ($job['meta_title'] !== null && $job['meta_title'] !== ''
                                    ? $job['meta_title']
                                    : $job['title']) . ' — ' . __('site.name'),
            'metaDescription' => $job['meta_description'] !== null && $job['meta_description'] !== ''
                ? (string) $job['meta_description']
                : Html::excerpt((string) $job['body'], 30),
            'canonical'       => $this->route('careers.show', ['id' => $job['id'], 'slug' => $job['slug']]),
        ]);
    }
}
