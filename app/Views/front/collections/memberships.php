<?php
/**
 * Keanggotaan — the association table.
 *
 * The intro prose above the table is an about-section page (tabel_about_us
 * row 7 in the legacy schema), so it stays editable in the CMS; the table
 * itself is the membership collection.
 *
 * The legacy page printed the raw URL as the link text, which wrapped badly
 * on phones. Here the association name carries the link and the host is shown
 * as the label.
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
      <?php if ($intro !== null && !empty($intro['body'])): ?>
        <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
        <div class="c-prose" style="margin-bottom:32px"><?= $intro['body'] ?></div>
      <?php endif; ?>

      <?php if ($items === []): ?>
        <div class="c-empty"><?= e(__('collections.empty')) ?></div>
      <?php else: ?>
        <div class="c-tablewrap">
          <table class="c-table c-table--members">
            <thead>
              <tr>
                <th scope="col"><?= e(__('collections.association')) ?></th>
                <th scope="col"><?= e(__('collections.assoc_status')) ?></th>
                <th scope="col"><?= e(__('collections.link')) ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td>
                    <div class="c-member">
                      <?php if (!empty($item['image_path'])): ?>
                        <img class="c-member__logo" src="<?= e($item['image_path']) ?>"
                             alt="<?= e($item['title']) ?>" loading="lazy">
                      <?php endif; ?>
                      <span class="c-member__name"><?= e($item['title']) ?></span>
                    </div>
                  </td>
                  <td>
                    <?php if (!empty($item['body'])): ?>
                      <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
                      <div class="c-prose c-prose--compact"><?= $item['body'] ?></div>
                    <?php else: ?>
                      &mdash;
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($item['link'])): ?>
                      <?php $host = parse_url((string) $item['link'], PHP_URL_HOST); ?>
                      <a href="<?= e($item['link']) ?>" target="_blank" rel="noopener noreferrer">
                        <?= e($host !== null && $host !== false ? $host : $item['link']) ?>
                      </a>
                    <?php else: ?>
                      &mdash;
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
