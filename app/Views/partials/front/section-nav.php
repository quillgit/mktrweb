<?php
/**
 * Sidebar navigation for the current section.
 *
 * The legacy site hardcoded this list in every sibling module, so adding a page
 * meant editing a dozen files. Here it is one partial over a normalised menu
 * built by Mktr\Support\SectionMenu — which is also what the header renders,
 * so the two can no longer drift apart.
 *
 * @var array  $navItems  [['key','title','url','children'], …]
 * @var string $activeKey key of the entry to mark current
 * @var string $section
 */

$labels = [
    'about'          => __('nav.about'),
    'business'       => __('nav.business'),
    'sustainability' => __('nav.sustainability'),
    'governance'     => __('nav.governance'),
    'investor'       => __('nav.investor'),
    'hr'             => __('nav.hr'),
];
$label = isset($labels[$section]) ? $labels[$section] : $section;
?>
<nav class="c-sidenav" aria-label="<?= e($label) ?>">
  <h2 class="c-sidenav__title"><?= e($label) ?></h2>
  <ul class="c-sidenav__list">
    <?php foreach ($navItems as $item): ?>
      <?php $isCurrent = $item['key'] === $activeKey; ?>
      <li>
        <a class="c-sidenav__link<?= $isCurrent ? ' is-active' : '' ?>"
           href="<?= e($item['url']) ?>"
           <?= $isCurrent ? 'aria-current="page"' : '' ?>><?= e($item['title']) ?></a>

        <?php if ($item['children'] !== []): ?>
          <ul class="c-sidenav__sub">
            <?php foreach ($item['children'] as $child): ?>
              <?php $childCurrent = $child['key'] === $activeKey; ?>
              <li>
                <a class="c-sidenav__link c-sidenav__link--child<?= $childCurrent ? ' is-active' : '' ?>"
                   href="<?= e($child['url']) ?>"
                   <?= $childCurrent ? 'aria-current="page"' : '' ?>><?= e($child['title']) ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
