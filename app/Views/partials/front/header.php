<?php
/**
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

$isNews = strpos($relative, '/berita') === 0 || strpos($relative, '/read/') === 0;

/*
 * Only the News route exists so far; the rest of the sitemap arrives in P2.
 * Items without a route yet are rendered as plain text rather than dead links.
 */
$navItems = [
    ['label' => __('nav.about'),          'url' => null,                            'active' => false],
    ['label' => __('nav.business'),       'url' => null,                            'active' => false],
    ['label' => __('nav.sustainability'), 'url' => null,                            'active' => false],
    ['label' => __('nav.governance'),     'url' => null,                            'active' => false],
    ['label' => __('nav.investor'),       'url' => null,                            'active' => false],
    ['label' => __('nav.news'),           'url' => $router->url('news.index'),      'active' => $isNews],
];

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
           href="<?= e($url) ?>"
           hreflang="<?= e($code) ?>"><?= e(config('app.locale_names.' . $code, strtoupper($code))) ?></a>
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
      <?php foreach ($navItems as $item): ?>
        <?php if ($item['url'] === null): ?>
          <span class="c-nav__link" aria-disabled="true"><?= e($item['label']) ?></span>
        <?php else: ?>
          <a class="c-nav__link<?= $item['active'] ? ' is-active' : '' ?>"
             href="<?= e($item['url']) ?>"
             <?= $item['active'] ? 'aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
  </div>
</header>
