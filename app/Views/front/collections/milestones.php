<?php
/**
 * Peristiwa Penting — the company timeline.
 *
 * The legacy page alternated items left/right around a centre line with an
 * inline <script> that toggled tooltips no markup ever rendered. Here the
 * alternation is CSS, so it collapses to a single column on narrow screens
 * instead of overflowing.
 *
 * @var array  $items
 * @var array  $page
 * @var array|null $intro
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
      <?php if ($intro !== null && !empty($intro['body'])): ?>
        <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
        <div class="c-prose" style="margin-bottom:40px"><?= $intro['body'] ?></div>
      <?php endif; ?>

      <?php if ($items === []): ?>
        <div class="c-empty"><?= e(__('collections.empty')) ?></div>
      <?php else: ?>
        <ol class="c-timeline">
          <?php foreach ($items as $item): ?>
            <li class="c-timeline__item">
              <span class="c-timeline__dot" aria-hidden="true"></span>
              <div class="c-timeline__card">
                <h2 class="c-timeline__year"><?= e($item['title']) ?></h2>
                <?php if (!empty($item['body'])): ?>
                  <div class="c-prose c-timeline__body"><?= $item['body'] ?></div>
                <?php endif; ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php endif; ?>
    </div>
  </div>
</section>
