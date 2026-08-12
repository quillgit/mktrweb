<?php
/**
 * The one place that knows what the "Tentang Kami" menu contains.
 *
 * The legacy site hardcoded this list eleven times — once in the header
 * (configuration/function.php) and once in every sibling module — and the
 * copies had already drifted apart. It is awkward because the section mixes
 * two kinds of entry:
 *
 *   - CMS pages   (profil_kami, logo_kami, visi_misi, …) — rows in `pages`
 *   - collections (peristiwa_penting, dewan_komisaris, …) — fixed routes
 *     backed by `collection_items`, with no page row of their own
 *
 * Rather than force collections into the pages table (they have no body, and
 * an editor deleting one would break a route), the order is declared here and
 * the page rows are slotted into it by slug. Pages the CMS adds later that are
 * not in the declared order are appended, so the menu never hides content.
 *
 * Every entry is normalised to ['key', 'title', 'url', 'children'] so the
 * header dropdown and the sidebar render from the same shape.
 */

namespace Mktr\Support;

use Mktr\Core\Config;
use Mktr\Core\Lang;
use Mktr\Core\Router;

class SectionMenu
{
    /**
     * Declared order of the about section, matching the legacy header exactly.
     * `page:<slug>` is filled from the pages table; `collection:<name>` is a
     * fixed route. Children are nested one level, as in the legacy menu.
     *
     * @var array<int,array{0:string,1:array<int,string>}>
     */
    private static $aboutOrder = [
        ['page:profil_kami',          []],
        ['page:logo_kami',            []],
        ['page:visi_misi',            []],
        ['collection:milestones',     []],
        ['page:struktur_kepemilikan', []],
        ['page:struktur_organisasi',  ['collection:commissioners', 'collection:directors']],
        ['page:struktur_group',       []],
        ['collection:subsidiaries',   []],
        ['collection:awards',         []],
        ['collection:memberships',    []],
    ];

    /**
     * collection key => [route name, translation key].
     *
     * @var array<string,array{0:string,1:string}>
     */
    private static $collections = [
        'milestones'    => ['collections.milestones',    'nav.milestones'],
        'commissioners' => ['collections.commissioners', 'nav.commissioners'],
        'directors'     => ['collections.directors',     'nav.directors'],
        'subsidiaries'  => ['collections.subsidiaries',  'nav.subsidiaries'],
        'awards'        => ['collections.awards',        'nav.awards'],
        'memberships'   => ['collections.memberships',   'nav.memberships'],
    ];

    /**
     * Normalised about menu.
     *
     * @param  array<int,array<string,mixed>> $pages rows from Page::sectionTree('about') or Page::navigation()['about']
     * @return array<int,array<string,mixed>>
     */
    public static function about(Router $router, array $pages): array
    {
        $bySlug = [];
        foreach ($pages as $page) {
            $bySlug[(string) $page['slug']] = $page;
        }

        $used  = [];
        $items = [];

        foreach (self::$aboutOrder as $entry) {
            list($key, $childKeys) = $entry;

            $item = self::resolve($router, $key, $bySlug, $used);

            if ($item === null) {
                // A page in the declared order is unpublished — skip it, but
                // keep its children (Dewan Komisaris does not disappear just
                // because the Struktur Organisasi page is a draft).
                foreach ($childKeys as $childKey) {
                    $child = self::resolve($router, $childKey, $bySlug, $used);
                    if ($child !== null) {
                        $items[] = $child;
                    }
                }
                continue;
            }

            foreach ($childKeys as $childKey) {
                $child = self::resolve($router, $childKey, $bySlug, $used);
                if ($child !== null) {
                    $item['children'][] = $child;
                }
            }

            $items[] = $item;
        }

        /* Anything the CMS added that the declared order does not mention. */
        foreach ($pages as $page) {
            if (isset($used[(string) $page['slug']]) || $page['parent_id'] !== null) {
                continue;
            }

            $items[] = self::pageItem($router, $page);
        }

        return $items;
    }

    /**
     * Normalised menu for the sections that are pages all the way down.
     *
     * @param  array<int,array<string,mixed>> $pages rows from Page::sectionTree()
     * @return array<int,array<string,mixed>>
     */
    public static function forSection(Router $router, string $section, array $pages): array
    {
        if ($section === 'about') {
            return self::about($router, $pages);
        }

        $children = [];
        foreach ($pages as $page) {
            if ($page['parent_id'] !== null) {
                $children[(int) $page['parent_id']][] = $page;
            }
        }

        $items = [];
        foreach ($pages as $page) {
            if ($page['parent_id'] !== null) {
                continue;
            }

            $item = self::pageItem($router, $page, $section);

            foreach (isset($children[(int) $page['id']]) ? $children[(int) $page['id']] : [] as $child) {
                $item['children'][] = self::pageItem($router, $child, $section);
            }

            $items[] = $item;
        }

        return $items;
    }

    /**
     * The key identifying the currently open entry, for the `is-active` state.
     */
    public static function pageKey(int $pageId): string
    {
        return 'page:' . $pageId;
    }

    public static function collectionKey(string $collection): string
    {
        return 'collection:' . $collection;
    }

    /**
     * @param  array<string,array<string,mixed>> $bySlug
     * @param  array<string,bool>                $used
     * @return array<string,mixed>|null
     */
    private static function resolve(Router $router, string $key, array $bySlug, array &$used): ?array
    {
        if (strpos($key, 'collection:') === 0) {
            $name = substr($key, strlen('collection:'));

            if (!isset(self::$collections[$name])) {
                return null;
            }

            return [
                'key'      => self::collectionKey($name),
                'title'    => Lang::get(self::$collections[$name][1]),
                'url'      => $router->url(self::$collections[$name][0]),
                'children' => [],
            ];
        }

        $slug = substr($key, strlen('page:'));

        if (!isset($bySlug[$slug])) {
            return null;
        }

        $used[$slug] = true;

        return self::pageItem($router, $bySlug[$slug]);
    }

    /**
     * @param  array<string,mixed> $page
     * @return array<string,mixed>
     */
    private static function pageItem(Router $router, array $page, string $section = 'about'): array
    {
        return [
            'key'      => self::pageKey((int) $page['id']),
            'title'    => (string) $page['title'],
            'url'      => self::pageUrl($router, $section, (string) $page['locale_slug']),
            'children' => [],
        ];
    }

    /**
     * About pages sit at the site root under their own slug; every other
     * section is a `/{prefix}/{slug}` route.
     */
    private static function pageUrl(Router $router, string $section, string $slug): string
    {
        if ($section !== 'about') {
            return $router->url('pages.' . $section, ['slug' => $slug]);
        }

        $base    = rtrim((string) Config::get('app.base_path', ''), '/');
        $default = (string) Config::get('app.default_locale', 'id');
        $lang    = $router->locale() !== $default ? '/' . $router->locale() : '';

        return $base . $lang . '/' . $slug;
    }
}
