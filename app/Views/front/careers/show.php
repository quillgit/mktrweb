<?php
/**
 * Vacancy detail.
 *
 * @var array $job
 * @var \Mktr\Core\Router $router
 */
$layout = 'layouts.front';
?>
<section class="c-pagehead">
  <div class="c-pagehead__media">
    <img src="<?= e(!empty($job['cover_path']) ? $job['cover_path'] : asset('assets/images/backgrounds/background-min.jpg')) ?>" alt="" aria-hidden="true">
  </div>
  <div class="u-container c-pagehead__inner">
    <ul class="c-breadcrumb">
      <li><a href="<?= e($router->url('news.index')) ?>"><?= e(__('nav.home')) ?></a></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li><a href="<?= e($router->url('careers.index')) ?>"><?= e(__('careers.title')) ?></a></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e($job['title']) ?></h1>
  </div>
</section>

<section class="c-section">
  <div class="u-container">
    <article class="c-article">
      <div class="c-article__meta">
        <?php if (!empty($job['location'])): ?><span><?= e($job['location']) ?></span><?php endif; ?>
        <?php if (!empty($job['closes_on'])): ?>
          <span><?= e(__('careers.closes')) ?>: <?= e(format_date_id($job['closes_on'], $locale)) ?></span>
        <?php endif; ?>
      </div>

      <?php /* Sanitised on import and on save. */ ?>
      <div class="c-prose"><?= $job['body'] ?></div>

      <p style="margin-top:40px">
        <a class="c-btn c-btn--ghost" href="<?= e($router->url('careers.index')) ?>">
          <span aria-hidden="true">&larr;</span> <?= e(__('careers.back')) ?>
        </a>
      </p>
    </article>
  </div>
</section>
