<?php
/**
 * Vacancy listing.
 *
 * @var array $jobs
 * @var \Mktr\Core\Router $router
 */
$layout = 'layouts.front';
?>
<section class="c-pagehead">
  <div class="c-pagehead__media">
    <img src="<?= e(asset('assets/images/backgrounds/background-min.jpg')) ?>" alt="" aria-hidden="true">
  </div>
  <div class="u-container c-pagehead__inner">
    <ul class="c-breadcrumb">
      <li><a href="<?= e($router->url('news.index')) ?>"><?= e(__('nav.home')) ?></a></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li aria-current="page"><?= e(__('careers.title')) ?></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e(__('careers.title')) ?></h1>
    <p class="c-pagehead__lead"><?= e(__('careers.subtitle')) ?></p>
  </div>
</section>

<section class="c-section">
  <div class="u-container">
    <?php if ($jobs === []): ?>
      <div class="c-empty"><?= e(__('careers.empty')) ?></div>
    <?php else: ?>
      <div class="c-doclist">
        <?php foreach ($jobs as $job): ?>
          <?php $url = $router->url('careers.show', ['id' => $job['id'], 'slug' => $job['locale_slug']]); ?>
          <div class="c-doc-row">
            <div class="c-doc-row__body">
              <h2 class="c-doc-row__title"><a href="<?= e($url) ?>"><?= e($job['title']) ?></a></h2>
              <div class="c-doc-row__meta">
                <?php if (!empty($job['location'])): ?><?= e($job['location']) ?> · <?php endif; ?>
                <?php if (!empty($job['closes_on'])): ?>
                  <?= e(__('careers.closes')) ?>: <?= e(format_date_id($job['closes_on'], $locale)) ?>
                <?php else: ?>
                  <?= e(__('careers.open')) ?>
                <?php endif; ?>
              </div>
            </div>
            <a class="c-doc-dl" href="<?= e($url) ?>"><?= e(__('careers.detail')) ?> <span aria-hidden="true">&rarr;</span></a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
