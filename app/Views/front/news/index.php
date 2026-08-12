<?php
/**
 * News listing.
 *
 * @var array               $posts
 * @var \Mktr\Core\Paginator $paginator
 * @var \Mktr\Core\Router    $router
 * @var string               $locale
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
      <li aria-current="page"><?= e(__('news.title')) ?></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e(__('news.title')) ?></h1>
    <p class="c-pagehead__lead"><?= e(__('news.subtitle')) ?></p>
  </div>
</section>

<section class="c-section">
  <div class="u-container">
    <?php if ($posts === []): ?>
      <div class="c-empty"><?= e(__('news.empty')) ?></div>
    <?php else: ?>
      <div class="c-grid c-grid--3">
        <?php foreach ($posts as $post): ?>
          <?php $url = $router->url('news.show', ['id' => $post['id'], 'slug' => $post['slug']]); ?>
          <article class="c-card">
            <div class="c-card__media">
              <?php if (!empty($post['cover_path'])): ?>
                <img src="<?= e($post['cover_path']) ?>"
                     alt="<?= e($post['cover_alt'] !== null ? $post['cover_alt'] : $post['title']) ?>"
                     <?= !empty($post['cover_width']) ? 'width="' . (int) $post['cover_width'] . '"' : '' ?>
                     <?= !empty($post['cover_height']) ? 'height="' . (int) $post['cover_height'] . '"' : '' ?>
                     loading="lazy">
              <?php endif; ?>
              <div class="c-card__date"><?= format_date_badge($post['published_at'], $locale) ?></div>
            </div>
            <div class="c-card__body">
              <h2 class="c-card__title"><a href="<?= e($url) ?>"><?= e($post['title']) ?></a></h2>
              <?php if (!empty($post['excerpt'])): ?>
                <p class="c-card__excerpt"><?= e($post['excerpt']) ?></p>
              <?php endif; ?>
              <a class="c-card__more" href="<?= e($url) ?>">
                <?= e(__('news.read_more')) ?> <span aria-hidden="true">&rarr;</span>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <?php if ($paginator->hasPages()): ?>
        <nav class="c-pagination" aria-label="<?= e(__('common.page')) ?>">
          <?php if ($paginator->currentPage() > 1): ?>
            <a href="<?= e($paginator->urlFor($paginator->currentPage() - 1)) ?>" rel="prev"><?= e(__('common.previous')) ?></a>
          <?php endif; ?>

          <?php foreach ($paginator->window() as $page): ?>
            <?php if ($page === 0): ?>
              <span class="is-gap" aria-hidden="true">&hellip;</span>
            <?php elseif ($page === $paginator->currentPage()): ?>
              <span class="is-current" aria-current="page"><?= (int) $page ?></span>
            <?php else: ?>
              <a href="<?= e($paginator->urlFor($page)) ?>"><?= (int) $page ?></a>
            <?php endif; ?>
          <?php endforeach; ?>

          <?php if ($paginator->currentPage() < $paginator->lastPage()): ?>
            <a href="<?= e($paginator->urlFor($paginator->currentPage() + 1)) ?>" rel="next"><?= e(__('common.next')) ?></a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
