<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Html;
use Mktr\Core\Response;
use Mktr\Models\CollectionItem;
use Mktr\Models\Page;
use Mktr\Support\SectionMenu;

/**
 * The six small "about" collections and the leadership detail page.
 *
 * Replaces module/{peristiwa_penting,dewan_komisaris,direksi,mktr_so,
 * anak_perusahaan_kami,penghargaan,keanggotaan}.php — seven files that each
 * repeated the header, the banner, the sidebar and one query. Here the query
 * is a `kind` and everything else is shared.
 *
 * Two of these pages had an editable intro in the legacy site: /keanggotaan
 * read tabel_about_us row 7 and /peristiwa_penting row 4. That intro is a page
 * row in the new schema, so it is looked up by slug and rendered when it is
 * published — the collection still shows if it is not.
 */
class CollectionController extends Controller
{
    /** Collection route slug => the about page whose prose introduces it. */
    private static $intros = [
        'peristiwa_penting' => 'peristiwa_penting',
        'keanggotaan'       => 'keanggotaan',
    ];

    public function milestones(array $params): Response
    {
        $context = $this->context('milestones', 'peristiwa_penting', __('nav.milestones'));

        // Newest first, matching the legacy `ORDER BY title DESC` where the
        // title is the year.
        $items = $this->items('milestone');
        usort($items, function (array $a, array $b) {
            return strcmp((string) $b['title'], (string) $a['title']);
        });

        $context['items'] = $items;

        return $this->view('front.collections.milestones', $context);
    }

    /**
     * /dewan_komisaris shows both boards — commissioners then directors — as
     * the legacy page did. /direksi shows the directors alone.
     */
    public function commissioners(array $params): Response
    {
        $context = $this->context('commissioners', 'dewan_komisaris', __('nav.commissioners'));

        $context['boards'] = [
            ['label' => __('nav.commissioners'), 'items' => $this->items('leadership', 'dewan_komisaris')],
            ['label' => __('nav.directors'),     'items' => $this->items('leadership', 'dewan_direksi')],
        ];

        return $this->view('front.collections.leadership', $context);
    }

    public function directors(array $params): Response
    {
        $context = $this->context('directors', 'direksi', __('nav.directors'));

        $context['boards'] = [
            ['label' => __('nav.directors'), 'items' => $this->items('leadership', 'dewan_direksi')],
        ];

        return $this->view('front.collections.leadership', $context);
    }

    public function subsidiaries(array $params): Response
    {
        $context          = $this->context('subsidiaries', 'anak_perusahaan_kami', __('nav.subsidiaries'));
        $context['items'] = $this->items('subsidiary');

        return $this->view('front.collections.subsidiaries', $context);
    }

    public function awards(array $params): Response
    {
        $context          = $this->context('awards', 'penghargaan', __('nav.awards'));
        $context['items'] = $this->items('award');

        return $this->view('front.collections.awards', $context);
    }

    public function memberships(array $params): Response
    {
        $context          = $this->context('memberships', 'keanggotaan', __('nav.memberships'));
        $context['items'] = $this->items('membership');

        return $this->view('front.collections.memberships', $context);
    }

    /**
     * /mktr_so/{slug} — a single member of the board, plus their colleagues.
     */
    public function person(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');
        $slug     = isset($params['slug']) ? (string) $params['slug'] : '';

        $collection = new CollectionItem();
        $person     = $collection->findPublishedBySlug('leadership', $slug, $locale, $fallback);

        if ($person === null) {
            return $this->notFound();
        }

        $group = (string) $person['group_key'];
        $isBoard = $group === 'dewan_komisaris';

        $colleagues = array_values(array_filter(
            $collection->published('leadership', $locale, $fallback, $group),
            function (array $item) use ($person) {
                return (int) $item['id'] !== (int) $person['id'];
            }
        ));

        $context = $this->context(
            $isBoard ? 'commissioners' : 'directors',
            $isBoard ? 'dewan_komisaris' : 'direksi',
            (string) $person['title']
        );

        $context['person']     = $person;
        $context['colleagues'] = $colleagues;
        $context['boardLabel'] = $isBoard ? __('nav.commissioners') : __('nav.directors');
        $context['boardUrl']   = $this->route($isBoard ? 'collections.commissioners' : 'collections.directors');
        $context['title']      = $person['title'] . ' — ' . __('site.name');
        $context['metaDescription'] = $person['subtitle'] !== null && $person['subtitle'] !== ''
            ? (string) $person['subtitle']
            : Html::excerpt((string) $person['body'], 30);
        $context['canonical']  = $this->route('collections.person', ['slug' => $person['slug']]);

        return $this->view('front.collections.person', $context);
    }

    /* ---- shared ----------------------------------------------------------- */

    /**
     * @return array<int,array<string,mixed>>
     */
    private function items(string $kind, ?string $group = null): array
    {
        return (new CollectionItem())->published(
            $kind,
            $this->router->locale(),
            (string) Config::get('app.default_locale', 'id'),
            $group
        );
    }

    /**
     * Everything the shared page furniture needs: the banner/title block, the
     * about sidebar with this collection marked current, and the optional CMS
     * intro page.
     *
     * @return array<string,mixed>
     */
    private function context(string $collection, string $routeSlug, string $heading): array
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');

        $pages = new Page();
        $intro = null;

        if (isset(self::$intros[$routeSlug])) {
            $intro = $pages->findBySlug('about', self::$intros[$routeSlug], $locale, $fallback);
        }

        /*
         * The page-head partial takes a page-shaped array. Collections have no
         * page row of their own, so one is synthesised from the heading and —
         * when an intro page exists — its banner, keeping the banner editable
         * from the CMS.
         */
        $head = [
            'id'          => 0,
            'title'       => $heading,
            'subtitle'    => $intro !== null ? $intro['subtitle'] : null,
            'banner_path' => $intro !== null ? $intro['banner_path'] : null,
        ];

        return [
            'section'         => 'about',
            'collection'      => $collection,
            'page'            => $head,
            'intro'           => $intro,
            'navItems'        => SectionMenu::about($this->router, $pages->sectionTree('about', $locale, $fallback)),
            'activeKey'       => SectionMenu::collectionKey($collection),
            'title'           => $heading . ' — ' . __('site.name'),
            'metaDescription' => $intro !== null && $intro['meta_description'] !== null && $intro['meta_description'] !== ''
                ? (string) $intro['meta_description']
                : $heading . ' — ' . __('site.name'),
            'canonical'       => $this->route('collections.' . $collection),
        ];
    }
}
