<?php

namespace Mktr\Controllers\Front;

use Mktr\Core\Config;
use Mktr\Core\Controller;
use Mktr\Core\Response;
use Mktr\Models\CollectionItem;
use Mktr\Models\Page;
use Mktr\Models\Post;
use Mktr\Models\Setting;

/**
 * The home page.
 *
 * module/home.php built this out of eight queries, four of which selected
 * content pages by hardcoded primary key (`id_berkelanjutan = '43'`,
 * `!= '1'`, `= '35'`) — so deleting a page in the CMS silently emptied a panel
 * on the front page, and reordering them shuffled it. Here the sustainability
 * highlights are simply the first published top-level pages of that section,
 * in the order the CMS already defines.
 */
class HomeController extends Controller
{
    /** Sustainability panels the legacy page showed. */
    const HIGHLIGHTS = 4;

    /** News cards under the fold. */
    const LATEST_NEWS = 3;

    public function index(array $params): Response
    {
        $locale   = $this->router->locale();
        $fallback = (string) Config::get('app.default_locale', 'id');

        $pages    = new Page();
        $settings = new Setting();

        return $this->view('front.home', [
            'banners'    => (new CollectionItem())->published('banner', $locale, $fallback),
            'introTitle' => $settings->text('home.intro_title', $locale, $fallback, __('nav.about')),
            'introBody'  => $settings->text('home.intro_body', $locale, $fallback),
            'introImage' => $settings->media('home.intro_body', $locale, $fallback, 1),
            'introImage2' => $settings->media('home.intro_body', $locale, $fallback, 2),
            'business'   => $pages->featured('business', $locale, $fallback, 8),
            'highlights' => $pages->featured('sustainability', $locale, $fallback, self::HIGHLIGHTS),
            'posts'      => (new Post())->publishedPage($locale, $fallback, self::LATEST_NEWS, 0),
            'title'      => __('site.name'),
            'metaDescription' => $settings->text('home.intro_body', $locale, $fallback) !== ''
                ? \Mktr\Core\Html::excerpt($settings->text('home.intro_body', $locale, $fallback), 30)
                : __('site.name'),
            'canonical'  => $this->route('home'),
        ]);
    }
}
