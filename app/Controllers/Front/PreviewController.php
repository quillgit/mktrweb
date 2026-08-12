<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Html;
use Mktr\Core\Lang;
use Mktr\Core\PreviewToken;
use Mktr\Core\Response;
use Mktr\Models\Post;

class PreviewController extends Controller
{
    /**
     * Render unpublished content through the real front-end template.
     */
    public function show(array $params): Response
    {
        $token   = isset($params['token']) ? (string) $params['token'] : '';
        $payload = PreviewToken::verify($token);

        if ($payload === null) {
            return $this->notFound();
        }

        if ($payload['type'] !== 'post') {
            return $this->notFound();
        }

        $locale = $payload['locale'];

        if (!in_array($locale, (array) Config::get('app.locales', ['id']), true)) {
            $locale = (string) Config::get('app.default_locale', 'id');
        }

        Lang::setLocale($locale);

        $posts        = new Post();
        $post         = $posts->find($payload['id']);
        $translations = $posts->translations($payload['id']);

        if ($post === null) {
            return $this->notFound();
        }

        $fallback = (string) Config::get('app.default_locale', 'id');
        $t        = isset($translations[$locale])
            ? $translations[$locale]
            : (isset($translations[$fallback]) ? $translations[$fallback] : null);

        if ($t === null) {
            return $this->notFound();
        }

        $cover = null;
        if (!empty($post['cover_media_id'])) {
            $cover = (new \Mktr\Models\Media())->find((int) $post['cover_media_id']);
        }

        $view = [
            'id'           => $post['id'],
            'slug'         => $post['slug'],
            'published_at' => $post['published_at'],
            'title'        => $t['title'],
            'excerpt'      => $t['excerpt'],
            'body'         => $t['body'],
            'cover_path'   => $cover !== null ? $cover['path'] : null,
            'cover_alt'    => $cover !== null ? $cover['alt'] : null,
            'cover_width'  => $cover !== null ? $cover['width'] : null,
            'cover_height' => $cover !== null ? $cover['height'] : null,
        ];

        $response = $this->view('front.news.show', [
            'post'            => $view,
            'related'         => [],
            'isPreview'       => true,
            'locale'          => $locale,
            'title'           => $t['title'] . ' — ' . __('site.name'),
            'metaDescription' => Html::excerpt((string) $t['body'], 30),
            // Drafts must never be indexed, even if a link leaks.
            'noindex'         => true,
        ]);

        return $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
