<?php
/**
 * Penghargaan & Pengakuan — certificate beside its citation.
 *
 * @var array  $items
 * @var array  $page
 * @var array  $navItems
 * @var string $activeKey
 * @var string $section
 */
$layout = 'layouts.front';
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => $section, 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-pagelayout">
    <aside class="c-pagelayout__side">
      <?= partial('partials.front.section-nav', [
          'navItems' => $navItems, 'activeKey' => $activeKey, 'section' => $section,
      ]) ?>
    </aside>

    <div class="c-pagelayout__main">
      <?php if ($items === []): ?>
        <div class="c-empty"><?= e(__('collections.empty')) ?></div>
      <?php else: ?>
        <?php foreach ($items as $item): ?>
          <article class="c-award">
            <div class="c-award__media">
              <?php if (!empty($item['image_path'])): ?>
                <a href="<?= e($item['image_path']) ?>" target="_blank" rel="noopener noreferrer"
                   title="<?= e(__('collections.zoom')) ?>">
                  <img src="<?= e($item['image_path']) ?>"
                       alt="<?= e($item['image_alt'] !== null && $item['image_alt'] !== '' ? $item['image_alt'] : $item['title']) ?>"
                       loading="lazy">
                </a>
              <?php endif; ?>
            </div>

            <div class="c-award__body">
              <p class="c-eyebrow"><?= e(__('nav.awards')) ?></p>
              <h2 class="c-award__title"><?= e($item['title']) ?></h2>
              <?php if (!empty($item['body'])): ?>
                <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
                <div class="c-prose"><?= $item['body'] ?></div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
