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

/** Section => [label, url prefix, route name]. Order matches the legacy menu. */
$sections = [
    'about'          => [__('nav.about'),          '',                        null],
    'business'       => [__('nav.business'),       '/bisnis',                 'pages.business'],
    'sustainability' => [__('nav.sustainability'), '/keberlanjutan',          'pages.sustainability'],
    'governance'     => [__('nav.governance'),     '/tatakelola_perusahaan',  'pages.governance'],
    'investor'       => [__('nav.investor'),       '/hubungan_investor',      'pages.investor'],
    'hr'             => [__('nav.hr'),             '/sdm',                    'pages.hr'],
];

$urlFor = function (string $section, array $item) use ($router, $sections, $base, $locale) {
    if ($section === 'about') {
        $lang = $locale !== (string) config('app.default_locale', 'id') ? '/' . $locale : '';

        return $base . $lang . '/' . $item['locale_slug'];
    }

    return $router->url($sections[$section][2], ['slug' => $item['locale_slug']]);
};

$isNews = strpos($relative, '/berita') === 0 || strpos($relative, '/read/') === 0;

$localeUrls = [];
foreach ((array) config('app.locales', ['id']) as $code) {
    $localeUrls[$code] = $router->url('news.index', [], $code);
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
    <a class="c-brand" href="<?= e($router->url('news.index')) ?>">
      <img src="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>" alt="<?= e(__('site.name')) ?>" width="52" height="52">
      <span class="c-brand__text"><?= e(__('site.name')) ?></span>
    </a>

    <button class="c-navtoggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="Menu">
      <span></span>
    </button>

    <nav class="c-nav" id="primary-nav" aria-label="Navigasi utama">
      <?php foreach ($sections as $key => $meta): ?>
        <?php
        $items = isset($nav[$key]) ? $nav[$key] : [];
        if ($items === []) {
            continue;
        }

        // Group children under their parent for the dropdown.
        $children = [];
        foreach ($items as $item) {
            if ($item['parent_id'] !== null) {
                $children[(int) $item['parent_id']][] = $item;
            }
        }

        $active = $meta[1] !== '' && strpos($relative, $meta[1]) === 0;
        ?>
        <div class="c-navitem">
          <button class="c-nav__link c-nav__toggle<?= $active ? ' is-active' : '' ?>"
                  type="button" aria-expanded="false"><?= e($meta[0]) ?>
            <span class="c-nav__caret" aria-hidden="true">&#9662;</span>
          </button>

          <ul class="c-dropdown">
            <?php foreach ($items as $item): ?>
              <?php if ($item['parent_id'] !== null) { continue; } ?>
              <li class="<?= isset($children[(int) $item['id']]) ? 'has-children' : '' ?>">
                <a href="<?= e($urlFor($key, $item)) ?>"><?= e($item['title']) ?></a>
                <?php if (isset($children[(int) $item['id']])): ?>
                  <ul class="c-dropdown c-dropdown--sub">
                    <?php foreach ($children[(int) $item['id']] as $child): ?>
                      <li><a href="<?= e($urlFor($key, $child)) ?>"><?= e($child['title']) ?></a></li>
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
    </nav>
  </div>
</header>
