<?php
/**
 * News detail.
 *
 * @var array            $post
 * @var array            $related
 * @var \Mktr\Core\Router $router
 * @var string            $locale
 * @var bool              $isPreview
 */

$layout    = 'layouts.front';
$isPreview = isset($isPreview) ? (bool) $isPreview : false;
?>
<?php if ($isPreview): ?>
  <div class="c-preview-bar"><?= e(__('preview.banner')) ?></div>
<?php endif; ?>

<section class="c-pagehead">
  <div class="c-pagehead__media">
    <img src="<?= e(!empty($post['cover_path']) ? $post['cover_path'] : asset('assets/images/backgrounds/background-min.jpg')) ?>" alt="" aria-hidden="true">
  </div>
  <div class="u-container c-pagehead__inner">
    <ul class="c-breadcrumb">
      <li><a href="<?= e($router->url('home')) ?>"><?= e(__('nav.home')) ?></a></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li><a href="<?= e($router->url('news.index')) ?>"><?= e(__('news.title')) ?></a></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e($post['title']) ?></h1>
  </div>
</section>

<section class="c-section">
  <div class="u-container">
    <article class="c-article">
      <div class="c-article__meta">
        <span><?= e(__('news.published_on')) ?>: <?= e(format_date_id($post['published_at'], $locale)) ?></span>
      </div>

      <?php if (!empty($post['cover_path'])): ?>
        <figure class="c-article__cover">
          <img src="<?= e($post['cover_path']) ?>"
               alt="<?= e($post['cover_alt'] !== null ? $post['cover_alt'] : $post['title']) ?>"
               <?= !empty($post['cover_width']) ? 'width="' . (int) $post['cover_width'] . '"' : '' ?>
               <?= !empty($post['cover_height']) ? 'height="' . (int) $post['cover_height'] . '"' : '' ?>>
        </figure>
      <?php endif; ?>

      <?php /* Body HTML is sanitised on save by Mktr\Core\Html::sanitize(). */ ?>
      <div class="c-prose"><?= $post['body'] ?></div>

      <p style="margin-top:40px">
        <a class="c-btn c-btn--ghost" href="<?= e($router->url('news.index')) ?>">
          <span aria-hidden="true">&larr;</span> <?= e(__('news.back')) ?>
        </a>
      </p>
    </article>
  </div>
</section>

<?php if ($related !== []): ?>
<section class="c-section c-section--sunken c-section--tight">
  <div class="u-container">
    <span class="c-eyebrow"><?= e(__('news.related')) ?></span>
    <div class="c-grid c-grid--3" style="margin-top:24px">
      <?php foreach ($related as $item): ?>
        <?php $url = $router->url('news.show', ['id' => $item['id'], 'slug' => $item['slug']]); ?>
        <article class="c-card">
          <div class="c-card__media">
            <?php if (!empty($item['cover_path'])): ?>
              <img src="<?= e($item['cover_path']) ?>"
                   alt="<?= e($item['cover_alt'] !== null ? $item['cover_alt'] : $item['title']) ?>"
                   loading="lazy">
            <?php endif; ?>
            <div class="c-card__date"><?= format_date_badge($item['published_at'], $locale) ?></div>
          </div>
          <div class="c-card__body">
            <h3 class="c-card__title"><a href="<?= e($url) ?>"><?= e($item['title']) ?></a></h3>
            <a class="c-card__more" href="<?= e($url) ?>">
              <?= e(__('news.read_more')) ?> <span aria-hidden="true">&rarr;</span>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
