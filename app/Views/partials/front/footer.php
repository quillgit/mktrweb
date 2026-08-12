<?php
/**
 * Site footer.
 *
 * The column links were placeholder <span>s; they are now real links built
 * from the same SectionMenu the header uses. The address and the corporate
 * email come from site settings rather than being typed in here, so changing
 * an office address is an edit in the CMS, not a deploy.
 *
 * @var \Mktr\Core\Router $router
 * @var string $locale
 */

$fallback = (string) config('app.default_locale', 'id');
$pages    = new \Mktr\Models\Page();
$settings = new \Mktr\Models\Setting();
$nav      = $pages->navigation($locale, $fallback);

$menuFor = function (string $section) use ($router, $nav) {
    return array_slice(
        \Mktr\Support\SectionMenu::forSection($router, $section, isset($nav[$section]) ? $nav[$section] : []),
        0,
        6
    );
};

$address = $settings->text('contact.address', $locale, $fallback,
    'Gedung Maktour, Jl. Ir. H. Juanda III No. 26, Jakarta Pusat 10120, Indonesia');
$email   = $settings->text('contact.email', $locale, $fallback, 'corsec@mktr.co.id');
$phone   = $settings->text('contact.phone', $locale, $fallback);

$columns = [
    ['label' => __('nav.about'),          'items' => $menuFor('about')],
    ['label' => __('nav.sustainability'), 'items' => $menuFor('sustainability')],
    ['label' => __('nav.investor'),       'items' => $menuFor('investor')],
];
?>
<footer class="c-footer">
  <div class="u-container">
    <div class="c-footer__grid">
      <?php foreach ($columns as $column): ?>
        <div>
          <h3><?= e($column['label']) ?></h3>
          <ul>
            <?php foreach ($column['items'] as $item): ?>
              <li><a href="<?= e($item['url']) ?>"><?= e($item['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>

      <div>
        <h3><?= e(__('nav.contact')) ?></h3>
        <p><?= nl2br(e($address)) ?></p>
        <?php if ($email !== ''): ?>
          <p><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
        <?php endif; ?>
        <?php if ($phone !== ''): ?>
          <p><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>"><?= e($phone) ?></a></p>
        <?php endif; ?>

        <ul style="margin-top:14px">
          <li><a href="<?= e($router->url('forms.contact')) ?>"><?= e(__('nav.contact')) ?></a></li>
          <li><a href="<?= e($router->url('news.index')) ?>"><?= e(__('nav.news')) ?></a></li>
          <li><a href="<?= e($router->url('careers.index')) ?>"><?= e(__('nav.career')) ?></a></li>
        </ul>
      </div>
    </div>

    <div class="c-footer__bottom">
      <span>&copy; <?= date('Y') ?> <?= e(__('site.name')) ?></span>
      <span>IDX: MKTR</span>
    </div>
  </div>
</footer>
