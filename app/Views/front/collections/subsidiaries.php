<?php
/**
 * Anak Perusahaan Kami — image over prose, one block per subsidiary.
 *
 * @var array  $items
 * @var array|null $intro
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
          <article class="c-feature">
            <h2 class="c-feature__title"><?= e($item['title']) ?></h2>

            <?php if (!empty($item['image_path'])): ?>
              <figure class="c-feature__media">
                <img src="<?= e($item['image_path']) ?>"
                     alt="<?= e($item['image_alt'] !== null && $item['image_alt'] !== '' ? $item['image_alt'] : $item['title']) ?>"
                     loading="lazy">
              </figure>
            <?php endif; ?>

            <?php if (!empty($item['body'])): ?>
              <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
              <div class="c-prose"><?= $item['body'] ?></div>
            <?php endif; ?>

            <?php if (!empty($item['link'])): ?>
              <p><a class="c-btn c-btn--ghost c-btn--sm" href="<?= e($item['link']) ?>"
                    target="_blank" rel="noopener noreferrer"><?= e(__('collections.visit')) ?></a></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
