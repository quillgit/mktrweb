<?php
/**
 * Page header for content pages: banner, breadcrumb, title.
 *
 * The legacy site repeated this block inline in all 28 module files.
 *
 * @var array  $page
 * @var string $section
 * @var \Mktr\Core\Router $router
 */

$sectionLabels = [
    'about'          => __('nav.about'),
    'business'       => __('nav.business'),
    'sustainability' => __('nav.sustainability'),
    'governance'     => __('nav.governance'),
    'investor'       => __('nav.investor'),
    'hr'             => __('nav.hr'),
    'contact'        => __('nav.contact'),
    'search'         => __('search.title'),
];

$banner = !empty($page['banner_path'])
    ? $page['banner_path']
    : asset('assets/images/backgrounds/background-min.jpg');
?>
<section class="c-pagehead">
  <div class="c-pagehead__media">
    <img src="<?= e($banner) ?>" alt="" aria-hidden="true">
  </div>
  <div class="u-container c-pagehead__inner">
    <ul class="c-breadcrumb">
      <li><a href="<?= e($router->url('home')) ?>"><?= e(__('nav.home')) ?></a></li>
      <?php
      $sectionLabel = isset($sectionLabels[$section]) ? $sectionLabels[$section] : $section;
      /* A standalone page (contact, search) is its own section — one crumb. */
      ?>
      <?php if ($sectionLabel !== $page['title']): ?>
        <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
        <li><?= e($sectionLabel) ?></li>
      <?php endif; ?>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li aria-current="page"><?= e($page['title']) ?></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e($page['title']) ?></h1>
    <?php if (!empty($page['subtitle']) && $page['subtitle'] !== $page['title']): ?>
      <p class="c-pagehead__lead"><?= e($page['subtitle']) ?></p>
    <?php endif; ?>
  </div>
</section>
