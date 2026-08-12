<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Html;
use Mktr\Core\Paginator;
use Mktr\Core\Response;
use Mktr\Models\Post;

class NewsController extends Controller
{
    public function index(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $perPage  = (int) Config::get('app.per_page', 9);

        // Page arrives either as /berita/{page} or ?page=
        $page = isset($params['page']) ? (int) $params['page'] : $this->request->int('page', 1);
        $page = $page < 1 ? 1 : $page;

        $posts     = new Post();
        $total     = $posts->countPublished();
        $paginator = new Paginator($total, $perPage, $page, $this->route('news.index'));

        $rows = $posts->publishedPage($locale, $fallback, $paginator->perPage(), $paginator->offset());

        return $this->view('front.news.index', [
            'posts'           => $rows,
            'paginator'       => $paginator,
            'title'           => __('news.title') . ' — ' . __('site.name'),
            'metaDescription' => __('news.subtitle'),
            'canonical'       => $paginator->currentPage() > 1
                ? $paginator->urlFor($paginator->currentPage())
                : $this->route('news.index'),
        ]);
    }

    public function show(array $params): Response
    {
        $id       = isset($params['id']) ? (int) $params['id'] : 0;
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');

        $posts = new Post();
        $post  = $posts->findPublished($id, $locale, $fallback);

        if ($post === null) {
            return $this->notFound();
        }

        // Canonicalise: /read/{id}/{wrong-slug} redirects to the stored slug so
        // the same article is not indexed under many URLs.
        $slug = isset($params['slug']) ? (string) $params['slug'] : '';
        if ($slug !== (string) $post['slug']) {
            return $this->redirect(
                $this->route('news.show', ['id' => $post['id'], 'slug' => $post['slug']]),
                301
            );
        }

        $posts->incrementViews($id);

        $description = (string) ($post['meta_description'] !== null && $post['meta_description'] !== ''
            ? $post['meta_description']
            : Html::excerpt((string) $post['body'], 30));

        return $this->view('front.news.show', [
            'post'            => $post,
            'related'         => $posts->latestExcept($id, $locale, $fallback, 3),
            'isPreview'       => false,
            'title'           => ($post['meta_title'] !== null && $post['meta_title'] !== ''
                                    ? $post['meta_title']
                                    : $post['title']) . ' — ' . __('site.name'),
            'metaDescription' => $description,
            'ogImage'         => !empty($post['cover_path']) ? (string) $post['cover_path'] : '',
            'canonical'       => $this->route('news.show', ['id' => $post['id'], 'slug' => $post['slug']]),
        ]);
    }
}
