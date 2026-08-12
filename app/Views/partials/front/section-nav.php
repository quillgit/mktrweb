<?php
/**
 * Sidebar navigation for the current section.
 *
 * The legacy site hardcoded this list in every sibling module, so adding a page
 * meant editing a dozen files. Here it comes from the pages table.
 *
 * @var array  $sectionTree flat rows ordered parent-then-children
 * @var array  $page        the current page
 * @var string $section
 * @var \Mktr\Core\Router $router
 */

$routeFor = function (array $item) use ($router, $section) {
    $slug = (string) $item['locale_slug'];

    if ($section === 'about') {
        $base = rtrim((string) config('app.base_path', ''), '/');
        $lang = locale() !== (string) config('app.default_locale', 'id') ? '/' . locale() : '';

        return $base . $lang . '/' . $slug;
    }

    return $router->url('pages.' . $section, ['slug' => $slug]);
};

/** Group children under their parent so the list renders as a tree. */
$children = [];
foreach ($sectionTree as $item) {
    if ($item['parent_id'] !== null) {
        $children[(int) $item['parent_id']][] = $item;
    }
}

$labels = [
    'about'          => __('nav.about'),
    'business'       => __('nav.business'),
    'sustainability' => __('nav.sustainability'),
    'governance'     => __('nav.governance'),
    'investor'       => __('nav.investor'),
    'hr'             => __('nav.hr'),
];
?>
<nav class="c-sidenav" aria-label="<?= e(isset($labels[$section]) ? $labels[$section] : $section) ?>">
  <h2 class="c-sidenav__title"><?= e(isset($labels[$section]) ? $labels[$section] : $section) ?></h2>
  <ul class="c-sidenav__list">
    <?php foreach ($sectionTree as $item): ?>
      <?php if ($item['parent_id'] !== null) { continue; } ?>
      <?php $isCurrent = (int) $item['id'] === (int) $page['id']; ?>
      <li>
        <a class="c-sidenav__link<?= $isCurrent ? ' is-active' : '' ?>"
           href="<?= e($routeFor($item)) ?>"
           <?= $isCurrent ? 'aria-current="page"' : '' ?>><?= e($item['title']) ?></a>

        <?php if (isset($children[(int) $item['id']])): ?>
          <ul class="c-sidenav__sub">
            <?php foreach ($children[(int) $item['id']] as $child): ?>
              <?php $childCurrent = (int) $child['id'] === (int) $page['id']; ?>
              <li>
                <a class="c-sidenav__link c-sidenav__link--child<?= $childCurrent ? ' is-active' : '' ?>"
                   href="<?= e($routeFor($child)) ?>"
                   <?= $childCurrent ? 'aria-current="page"' : '' ?>><?= e($child['title']) ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>
