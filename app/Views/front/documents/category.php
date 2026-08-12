<?php
/**
 * Investor Relations — documents in one category.
 *
 * @var array  $category   id, slug, layout, name, description
 * @var array  $categories sibling categories for the tab strip
 * @var array  $documents
 * @var int[]  $years
 * @var int|null $activeYear
 * @var \Mktr\Core\Router $router
 * @var string $locale
 */

$layout = 'layouts.front';

$categoryUrl = $router->url('documents.category', ['slug' => $category['slug']]);
?>
<section class="c-pagehead">
  <div class="c-pagehead__media">
    <img src="<?= e(asset('assets/images/backgrounds/background-min.jpg')) ?>" alt="" aria-hidden="true">
  </div>
  <div class="u-container c-pagehead__inner">
    <ul class="c-breadcrumb">
      <li><a href="<?= e($router->url('home')) ?>"><?= e(__('nav.home')) ?></a></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li><?= e(__('nav.investor')) ?></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li aria-current="page"><?= e($category['name']) ?></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e($category['name']) ?></h1>
    <?php if (!empty($category['description'])): ?>
      <p class="c-pagehead__lead"><?= e($category['description']) ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="c-section">
  <div class="u-container">

    <nav class="c-doctabs" aria-label="<?= e(__('nav.investor')) ?>">
      <?php foreach ($categories as $item): ?>
        <a class="c-doctab<?= (int) $item['id'] === (int) $category['id'] ? ' is-active' : '' ?>"
           href="<?= e($router->url('documents.category', ['slug' => $item['slug']])) ?>"
           <?= (int) $item['id'] === (int) $category['id'] ? 'aria-current="page"' : '' ?>><?= e($item['name']) ?></a>
      <?php endforeach; ?>
    </nav>

    <?php if (count($years) > 1): ?>
      <div class="c-years">
        <span class="c-years__label"><?= e(__('documents.year')) ?></span>
        <a class="c-year<?= $activeYear === null ? ' is-active' : '' ?>" href="<?= e($categoryUrl) ?>">
          <?= e(__('documents.all_years')) ?>
        </a>
        <?php foreach ($years as $year): ?>
          <a class="c-year<?= $activeYear === $year ? ' is-active' : '' ?>"
             href="<?= e($categoryUrl . '?year=' . $year) ?>"><?= (int) $year ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($documents === []): ?>
      <div class="c-empty"><?= e(__('documents.empty')) ?></div>

    <?php elseif ($category['layout'] === 'cover-grid'): ?>
      <div class="c-doc-grid">
        <?php foreach ($documents as $document): ?>
          <?php $url = $router->url('documents.download', ['id' => $document['id'], 'slug' => str_slug((string) $document['title'])]); ?>
          <article class="c-doc-card">
            <div class="c-doc-card__cover">
              <?php if (!empty($document['cover_path'])): ?>
                <img src="<?= e($document['cover_path']) ?>"
                     alt="<?= e($document['cover_alt'] !== null ? $document['cover_alt'] : $document['title']) ?>"
                     loading="lazy">
              <?php endif; ?>
            </div>
            <div class="c-doc-card__body">
              <h2 class="c-doc-card__title"><?= e($document['title']) ?></h2>
              <?php if (!empty($document['document_date'])): ?>
                <div class="c-doc-card__meta"><?= e(format_date_id($document['document_date'], $locale)) ?></div>
              <?php endif; ?>
              <a class="c-doc-dl" href="<?= e($url) ?>" target="_blank" rel="noopener">
                <span aria-hidden="true">&darr;</span> <?= e(__('documents.download')) ?>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <div class="c-doclist">
        <?php foreach ($documents as $document): ?>
          <?php $url = $router->url('documents.download', ['id' => $document['id'], 'slug' => str_slug((string) $document['title'])]); ?>
          <div class="c-doc-row">
            <div class="c-doc-row__date">
              <?= e($document['document_date'] !== null ? format_date_id($document['document_date'], $locale) : '—') ?>
            </div>
            <div class="c-doc-row__body">
              <h2 class="c-doc-row__title"><?= e($document['title']) ?></h2>
              <?php if (!empty($document['description'])): ?>
                <div class="c-doc-row__meta"><?= e($document['description']) ?></div>
              <?php elseif (!empty($document['file_size'])): ?>
                <div class="c-doc-row__meta">PDF · <?= e(format_bytes((int) $document['file_size'])) ?></div>
              <?php endif; ?>
            </div>
            <a class="c-doc-dl" href="<?= e($url) ?>" target="_blank" rel="noopener">
              <span aria-hidden="true">&darr;</span> <?= e(__('documents.download')) ?>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
