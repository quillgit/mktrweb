<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Html;
use Mktr\Core\Response;
use Mktr\Models\Document;
use Mktr\Models\Grievance;
use Mktr\Models\Page;

/**
 * Content pages.
 *
 * Replaces module/{profil_kami,visi_misi,keberlanjutan,tatakelola_perusahaan,
 * sdm,hubungan_investor,bisnis_inti}.php — seven near-identical files whose
 * differences were the table they queried and the section links they hardcoded.
 * Here the section is the route and everything else is data.
 */
class PageController extends Controller
{
    /* One entry point per section, so the route table stays declarative. */

    public function about(array $params): Response
    {
        // The about routes are fixed paths (/profil_kami, /visi_misi, …) rather
        // than a {slug} pattern, so the slug is the last path segment.
        return $this->render('about', $this->slugFromPath());
    }

    public function business(array $params): Response
    {
        return $this->render('business', isset($params['slug']) ? (string) $params['slug'] : '');
    }

    public function sustainability(array $params): Response
    {
        return $this->render('sustainability', isset($params['slug']) ? (string) $params['slug'] : '');
    }

    public function governance(array $params): Response
    {
        return $this->render('governance', isset($params['slug']) ? (string) $params['slug'] : '');
    }

    public function investor(array $params): Response
    {
        return $this->render('investor', isset($params['slug']) ? (string) $params['slug'] : '');
    }

    public function hr(array $params): Response
    {
        return $this->render('hr', isset($params['slug']) ? (string) $params['slug'] : '');
    }

    private function slugFromPath(): string
    {
        $segments = array_values(array_filter(explode('/', $this->request->path())));

        return $segments === [] ? '' : (string) end($segments);
    }

    private function render(string $section, string $slug): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');

        $pages = new Page();
        $page  = $pages->findBySlug($section, $slug, $locale, $fallback);

        if ($page === null) {
            return $this->notFound();
        }

        $shared = [
            'page'        => $page,
            'section'     => $section,
            'sectionTree' => $pages->sectionTree($section, $locale, $fallback),
            'title'       => ($page['meta_title'] !== null && $page['meta_title'] !== ''
                                ? $page['meta_title']
                                : $page['title']) . ' — ' . __('site.name'),
            'metaDescription' => $page['meta_description'] !== null && $page['meta_description'] !== ''
                ? (string) $page['meta_description']
                : Html::excerpt((string) $page['body'], 30),
            'canonical'   => $this->pageUrl($section, (string) $page['locale_slug']),
        ];

        if ($page['type'] === 'documents') {
            return $this->renderDocuments($page, $shared, $locale, $fallback);
        }

        if ($page['type'] === 'grievances') {
            $shared['grievances'] = (new Grievance())->publicRegister();

            return $this->view('front.pages.grievances', $shared);
        }

        return $this->view('front.pages.text', $shared);
    }

    /**
     * A page of type `documents` shows a document listing. The category comes
     * from the page row, so the same controller serves every report type.
     */
    private function renderDocuments(array $page, array $shared, string $locale, string $fallback): Response
    {
        if (empty($page['document_category_id'])) {
            // Configured as a listing but pointed at nothing — render the page
            // shell with an empty state rather than a 500.
            $shared['documents']  = [];
            $shared['years']      = [];
            $shared['activeYear'] = null;

            return $this->view('front.pages.documents', $shared);
        }

        $documents  = new Document();
        $categoryId = (int) $page['document_category_id'];
        $years      = $documents->publishedYears($categoryId);

        $year = $this->request->int('year', 0);
        $year = ($year > 0 && in_array($year, $years, true)) ? $year : null;

        $shared['documents']  = $documents->publishedInCategory($categoryId, $locale, $fallback, $year);
        $shared['years']      = $years;
        $shared['activeYear'] = $year;

        return $this->view('front.pages.documents', $shared);
    }

    /**
     * Build the public URL for a page in a section.
     */
    private function pageUrl(string $section, string $slug): string
    {
        $named = [
            'business'       => 'pages.business',
            'sustainability' => 'pages.sustainability',
            'governance'     => 'pages.governance',
            'investor'       => 'pages.investor',
            'hr'             => 'pages.hr',
        ];

        if ($section === 'about') {
            // About pages sit at the site root under their own slug.
            $base = rtrim((string) Config::get('app.base_path', ''), '/');
            $lang = $this->router->locale() !== (string) Config::get('app.default_locale', 'id')
                ? '/' . $this->router->locale()
                : '';

            return $base . $lang . '/' . $slug;
        }

        return isset($named[$section]) ? $this->route($named[$section], ['slug' => $slug]) : '/';
    }
}
