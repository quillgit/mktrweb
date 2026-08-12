<?php
/**
 * Dewan Komisaris / Direksi — one or two boards of portrait cards.
 *
 * @var array  $boards  [['label' => …, 'items' => […]], …]
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
      <p class="c-eyebrow"><?= e(__('collections.management')) ?></p>

      <?php $rendered = 0; ?>
      <?php foreach ($boards as $board): ?>
        <?php if ($board['items'] === []) { continue; } ?>
        <?php $rendered++; ?>
        <div class="c-board">
          <h2 class="c-board__title"><?= e($board['label']) ?></h2>
          <div class="c-people">
            <?php foreach ($board['items'] as $person): ?>
              <?php $url = $router->url('collections.person', ['slug' => $person['slug']]); ?>
              <article class="c-person">
                <a class="c-person__link" href="<?= e($url) ?>">
                  <div class="c-person__photo">
                    <?php if (!empty($person['image_path'])): ?>
                      <img src="<?= e($person['image_path']) ?>"
                           alt="<?= e($person['title']) ?>" loading="lazy">
                    <?php endif; ?>
                  </div>
                  <div class="c-person__body">
                    <h3 class="c-person__name"><?= e($person['title']) ?></h3>
                    <?php if (!empty($person['subtitle'])): ?>
                      <p class="c-person__role"><?= e($person['subtitle']) ?></p>
                    <?php endif; ?>
                  </div>
                </a>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if ($rendered === 0): ?>
        <div class="c-empty"><?= e(__('collections.empty')) ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>
