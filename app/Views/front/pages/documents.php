<?php
/**
 * Content page rendering a document listing.
 *
 * @var array $page
 * @var array $sectionTree
 * @var array $documents
 * @var int[] $years
 * @var int|null $activeYear
 * @var string $section
 */
$layout = 'layouts.front';

$pageUrl = $section === 'about'
    ? '/' . $page['locale_slug']
    : $router->url('pages.' . $section, ['slug' => $page['locale_slug']]);
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => $section, 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-pagelayout">
    <aside class="c-pagelayout__side">
      <?= partial('partials.front.section-nav', [
          'sectionTree' => $sectionTree, 'page' => $page, 'section' => $section, 'router' => $router,
      ]) ?>
    </aside>

    <div class="c-pagelayout__main">
      <?php if (!empty($page['body'])): ?>
        <div class="c-prose" style="margin-bottom:32px"><?= $page['body'] ?></div>
      <?php endif; ?>

      <?php if (count($years) > 1): ?>
        <div class="c-years">
          <span class="c-years__label"><?= e(__('documents.year')) ?></span>
          <a class="c-year<?= $activeYear === null ? ' is-active' : '' ?>" href="<?= e($pageUrl) ?>"><?= e(__('documents.all_years')) ?></a>
          <?php foreach ($years as $year): ?>
            <a class="c-year<?= $activeYear === $year ? ' is-active' : '' ?>"
               href="<?= e($pageUrl . '?year=' . $year) ?>"><?= (int) $year ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ($documents === []): ?>
        <div class="c-empty"><?= e(__('documents.empty')) ?></div>
      <?php elseif (($page['category_layout'] ?? 'list') === 'cover-grid'): ?>
        <div class="c-doc-grid">
          <?php foreach ($documents as $document): ?>
            <?php $url = $router->url('documents.download', ['id' => $document['id'], 'slug' => str_slug((string) $document['title'])]); ?>
            <article class="c-doc-card">
              <div class="c-doc-card__cover">
                <?php if (!empty($document['cover_path'])): ?>
                  <img src="<?= e($document['cover_path']) ?>" alt="<?= e($document['title']) ?>" loading="lazy">
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
              <div class="c-doc-row__date"><?= e($document['document_date'] !== null ? format_date_id($document['document_date'], $locale) : '—') ?></div>
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
  </div>
</section>
