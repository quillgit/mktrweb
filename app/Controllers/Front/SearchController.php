<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Response;
use Mktr\Support\SiteSearch;

/**
 * Site search.
 *
 * The legacy scheme is preserved: the header form POSTs to /pencarian, which
 * slugs the query and redirects to /cari/{slug}, so a search result page has a
 * shareable URL. That is the one good idea in module/pencarian.php — the rest
 * of it was `echo "<script>window.location=('$link')</script>"` and an
 * interpolated LIKE.
 */
class SearchController extends Controller
{
    public function submit(array $params): Response
    {
        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $term = $this->request->text('q');
        $slug = str_slug($term);

        if ($slug === '') {
            return $this->redirect($this->route('home'));
        }

        return $this->redirect($this->route('search.results', ['slug' => $slug]));
    }

    public function results(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $slug     = isset($params['slug']) ? (string) $params['slug'] : '';
        $term     = SiteSearch::fromSlug($slug);

        $results = (new SiteSearch())->search($term, $locale, $fallback);

        return $this->view('front.search', [
            'term'    => $term,
            'results' => $results,
            'page'    => [
                'id' => 0,
                'title' => __('search.title'),
                'subtitle' => __('search.for', ['term' => $term]),
                'banner_path' => null,
            ],
            'title'           => __('search.for', ['term' => $term]) . ' — ' . __('site.name'),
            'metaDescription' => __('search.for', ['term' => $term]),
            'canonical'       => $this->route('search.results', ['slug' => $slug]),
            // A results page is thin content; keep it out of the index.
            'noindex'         => true,
        ]);
    }
}
