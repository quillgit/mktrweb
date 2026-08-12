<?php
/**
 * Search results.
 *
 * The legacy page returned two unlabelled lists — news, then sustainability —
 * with no indication of what a hit was. Each result here says what it is and
 * where it goes.
 *
 * @var string $term
 * @var array  $results
 * @var array  $page
 */
$layout = 'layouts.front';

$labels = [
    'page'     => __('nav.about'),
    'post'     => __('news.title'),
    'document' => __('search.kind.document'),
    'job'      => __('nav.career'),
];

$sectionRoutes = [
    'business'       => 'pages.business',
    'sustainability' => 'pages.sustainability',
    'governance'     => 'pages.governance',
    'investor'       => 'pages.investor',
    'hr'             => 'pages.hr',
];

$urlFor = function (array $result) use ($router, $sectionRoutes) {
    $t = $result['target'];

    switch ($result['kind']) {
        case 'post':
            return $router->url('news.show', ['id' => $t['id'], 'slug' => $t['slug']]);
        case 'document':
            return $router->url('documents.download', ['id' => $t['id'], 'slug' => str_slug($result['title'])]);
        case 'job':
            return $router->url('careers.show', ['id' => $t['id'], 'slug' => $t['slug']]);
        default:
            if ($t['section'] === 'about') {
                $base = rtrim((string) config('app.base_path', ''), '/');
                $lang = locale() !== (string) config('app.default_locale', 'id') ? '/' . locale() : '';

                return $base . $lang . '/' . $t['slug'];
            }

            return isset($sectionRoutes[$t['section']])
                ? $router->url($sectionRoutes[$t['section']], ['slug' => $t['slug']])
                : '#';
    }
};
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => 'search', 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-formpage">
    <form class="c-searchbar" method="post" action="<?= e($router->url('search.submit')) ?>">
      <?= csrf_field() ?>
      <label class="u-visually-hidden" for="q"><?= e(__('common.search')) ?></label>
      <input class="c-input" type="search" id="q" name="q" value="<?= e($term) ?>"
             placeholder="<?= e(__('common.search')) ?>&hellip;">
      <button class="c-btn" type="submit"><?= e(__('common.search')) ?></button>
    </form>

    <?php if ($results === []): ?>
      <div class="c-empty"><?= e(__('search.empty', ['term' => $term])) ?></div>
    <?php else: ?>
      <p class="c-form__note"><?= e(__('search.count', ['n' => count($results)])) ?></p>

      <ol class="c-results">
        <?php foreach ($results as $result): ?>
          <li class="c-result">
            <span class="c-result__kind"><?= e(isset($labels[$result['kind']]) ? $labels[$result['kind']] : $result['kind']) ?></span>
            <h2 class="c-result__title"><a href="<?= e($urlFor($result)) ?>"><?= e($result['title']) ?></a></h2>
            <?php if ($result['excerpt'] !== ''): ?>
              <p class="c-result__excerpt"><?= e($result['excerpt']) ?></p>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>
  </div>
</section>
