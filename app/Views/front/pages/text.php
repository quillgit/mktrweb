<?php
/**
 * Prose content page.
 *
 * @var array $page
 * @var array $navItems
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
      <?php if (!empty($page['body'])): ?>
        <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
        <div class="c-prose"><?= $page['body'] ?></div>
      <?php else: ?>
        <div class="c-empty"><?= e(__('pages.empty')) ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>
