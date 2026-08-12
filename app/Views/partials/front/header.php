<?php
/**
 * Site header.
 *
 * The navigation is built from the pages table — section, then parent, then
 * child — which is what header_menu() in the legacy configuration/function.php
 * did from the content tables. Nothing here is hardcoded except the section
 * order, so adding a page to the CMS adds it to the menu.
 *
 * @var \Mktr\Core\Router  $router
 * @var \Mktr\Core\Request $request
 * @var string             $locale
 */

$currentPath = $request->path();
$base        = rtrim((string) config('app.base_path', ''), '/');

/** Strip base path and locale prefix so the active check works in both locales. */
$relative = $currentPath;
if ($base !== '' && strpos($relative, $base) === 0) {
    $relative = substr($relative, strlen($base));
}
foreach ((array) config('app.locales', []) as $code) {
    if ($code === config('app.default_locale')) {
        continue;
    }
    if ($relative === '/' . $code) {
        $relative = '/';
    } elseif (strpos($relative, '/' . $code . '/') === 0) {
        $relative = substr($relative, strlen($code) + 1);
    }
}

$nav = (new \Mktr\Models\Page())->navigation(
    $locale,
    (string) config('app.default_locale', 'id')
);

/** Section => [label, url prefix]. Order matches the legacy menu. */
$sections = [
    'about'          => [__('nav.about'),          ''],
    'business'       => [__('nav.business'),       '/bisnis'],
    'sustainability' => [__('nav.sustainability'), '/keberlanjutan'],
    'governance'     => [__('nav.governance'),     '/tatakelola_perusahaan'],
    'investor'       => [__('nav.investor'),       '/hubungan_investor'],
    'hr'             => [__('nav.hr'),             '/sdm'],
];

/*
 * The menu is normalised by SectionMenu, which is also what the sidebar uses.
 * That matters for `about`, where the section mixes CMS pages with the six
 * fixed collection routes; the legacy site kept eleven hand-maintained copies
 * of that list.
 */
$menus = [];
foreach ($sections as $key => $meta) {
    $menus[$key] = \Mktr\Support\SectionMenu::forSection(
        $router,
        $key,
        isset($nav[$key]) ? $nav[$key] : []
    );
}

/** Paths owned by the about section that are not `/{page-slug}`. */
$aboutPaths = ['/peristiwa_penting', '/dewan_komisaris', '/direksi', '/mktr_so',
               '/anak_perusahaan_kami', '/penghargaan', '/keanggotaan'];

$isNews = strpos($relative, '/berita') === 0 || strpos($relative, '/read/') === 0;

$localeUrls = [];
foreach ((array) config('app.locales', ['id']) as $code) {
    $localeUrls[$code] = $router->url('home', [], $code);
}
?>
<div class="c-topbar">
  <div class="u-container c-topbar__inner">
    <div class="c-lang">
      <?php $first = true; foreach ($localeUrls as $code => $url): ?>
        <?php if (!$first): ?><span class="c-lang__sep">|</span><?php endif; ?>
        <a class="c-lang__link<?= $code === $locale ? ' is-active' : '' ?>"
           href="<?= e($url) ?>" hreflang="<?= e($code) ?>"><?= e(config('app.locale_names.' . $code, strtoupper($code))) ?></a>
        <?php $first = false; endforeach; ?>
    </div>

    <a class="c-topbar__contact" href="<?= e($router->url('forms.contact')) ?>"><?= e(__('nav.contact')) ?></a>

    <div class="c-social" aria-label="Media sosial">
      <a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
      <a href="https://instagram.com/mktr.id" target="_blank" rel="noopener noreferrer" aria-label="Instagram">ig</a>
      <a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
      <a href="https://www.youtube.com/@mktr5433" target="_blank" rel="noopener noreferrer" aria-label="YouTube">yt</a>
    </div>
  </div>
</div>

<header class="c-header">
  <div class="u-container c-header__inner">
    <a class="c-brand" href="<?= e($router->url('home')) ?>">
      <img src="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>" alt="<?= e(__('site.name')) ?>" width="52" height="52">
      <span class="c-brand__text"><?= e(__('site.name')) ?></span>
    </a>

    <button class="c-navtoggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="Menu">
      <span></span>
    </button>

    <nav class="c-nav" id="primary-nav" aria-label="Navigasi utama">
      <?php foreach ($sections as $key => $meta): ?>
        <?php
        $items = $menus[$key];
        if ($items === []) {
            continue;
        }

        if ($key === 'about') {
            $active = false;
            foreach ($aboutPaths as $path) {
                if (strpos($relative, $path) === 0) {
                    $active = true;
                    break;
                }
            }
        } else {
            $active = strpos($relative, $meta[1]) === 0;
        }
        ?>
        <div class="c-navitem">
          <button class="c-nav__link c-nav__toggle<?= $active ? ' is-active' : '' ?>"
                  type="button" aria-expanded="false"><?= e($meta[0]) ?>
            <span class="c-nav__caret" aria-hidden="true">&#9662;</span>
          </button>

          <ul class="c-dropdown">
            <?php foreach ($items as $item): ?>
              <li class="<?= $item['children'] !== [] ? 'has-children' : '' ?>">
                <a href="<?= e($item['url']) ?>"><?= e($item['title']) ?></a>
                <?php if ($item['children'] !== []): ?>
                  <ul class="c-dropdown c-dropdown--sub">
                    <?php foreach ($item['children'] as $child): ?>
                      <li><a href="<?= e($child['url']) ?>"><?= e($child['title']) ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>

      <a class="c-nav__link<?= $isNews ? ' is-active' : '' ?>" href="<?= e($router->url('news.index')) ?>"><?= e(__('nav.news')) ?></a>
      <a class="c-nav__link<?= strpos($relative, '/karir') === 0 ? ' is-active' : '' ?>" href="<?= e($router->url('careers.index')) ?>"><?= e(__('nav.career')) ?></a>

      <form class="c-navsearch" method="post" action="<?= e($router->url('search.submit')) ?>" role="search">
        <?= csrf_field() ?>
        <label class="u-visually-hidden" for="nav-q"><?= e(__('common.search')) ?></label>
        <input class="c-navsearch__input" type="search" id="nav-q" name="q"
               placeholder="<?= e(__('common.search')) ?>&hellip;">
        <button class="c-navsearch__btn" type="submit" aria-label="<?= e(__('common.search')) ?>">&#9906;</button>
      </form>
    </nav>
  </div>
</header>
