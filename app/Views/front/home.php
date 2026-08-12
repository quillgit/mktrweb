<?php
/**
 * Home page.
 *
 * @var array  $banners
 * @var string $introTitle
 * @var string $introBody
 * @var string $introImage
 * @var string $introImage2
 * @var array  $business
 * @var array  $highlights
 * @var array  $posts
 */
$layout = 'layouts.front';

$aboutUrl = (function () {
    $base = rtrim((string) config('app.base_path', ''), '/');
    $lang = locale() !== (string) config('app.default_locale', 'id') ? '/' . locale() : '';

    return $base . $lang . '/profil_kami';
})();
?>

<?php if ($banners !== []): ?>
  <section class="c-hero" aria-roledescription="carousel" aria-label="<?= e(__('site.name')) ?>">
    <div class="c-hero__track" id="hero-track">
      <?php foreach ($banners as $i => $banner): ?>
        <article class="c-hero__slide" role="group" aria-roledescription="slide"
                 aria-label="<?= (int) ($i + 1) ?> / <?= count($banners) ?>">
          <?php if (!empty($banner['image_path'])): ?>
            <picture>
              <?php if (!empty($banner['mobile_path'])): ?>
                <source media="(max-width: 640px)" srcset="<?= e($banner['mobile_path']) ?>">
              <?php endif; ?>
              <img src="<?= e($banner['image_path']) ?>" alt=""
                   <?= $i === 0 ? '' : 'loading="lazy"' ?> aria-hidden="true">
            </picture>
          <?php endif; ?>

          <div class="u-container c-hero__inner">
            <h1 class="c-hero__title"><?= e($banner['title']) ?></h1>
            <?php if (!empty($banner['body'])): ?>
              <p class="c-hero__lead"><?= e($banner['body']) ?></p>
            <?php endif; ?>
            <?php if (!empty($banner['link']) && $banner['link'] !== '#'): ?>
              <a class="c-btn c-btn--gold" href="<?= e($banner['link']) ?>"><?= e(__('news.read_more')) ?></a>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if (count($banners) > 1): ?>
      <div class="c-hero__dots" id="hero-dots" role="tablist" aria-label="Slide">
        <?php foreach ($banners as $i => $banner): ?>
          <button class="c-hero__dot<?= $i === 0 ? ' is-active' : '' ?>" type="button" role="tab"
                  data-slide="<?= (int) $i ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  aria-label="<?= (int) ($i + 1) ?>"></button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>

<?php if ($introBody !== '' || $introImage !== ''): ?>
  <section class="c-section">
    <div class="u-container c-intro">
      <div class="c-intro__media">
        <?php if ($introImage !== ''): ?>
          <img class="c-intro__img c-intro__img--1" src="<?= e($introImage) ?>" alt="" loading="lazy">
        <?php endif; ?>
        <?php if ($introImage2 !== ''): ?>
          <img class="c-intro__img c-intro__img--2" src="<?= e($introImage2) ?>" alt="" loading="lazy">
        <?php endif; ?>
      </div>

      <div class="c-intro__body">
        <p class="c-eyebrow"><?= e(__('site.short')) ?></p>
        <h2 class="c-sectiontitle"><?= e($introTitle) ?></h2>
        <?php if ($introBody !== ''): ?>
          <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
          <div class="c-prose"><?= $introBody ?></div>
        <?php endif; ?>
        <p style="margin-top:24px">
          <a class="c-btn" href="<?= e($aboutUrl) ?>"><?= e(__('news.read_more')) ?></a>
        </p>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if ($business !== []): ?>
  <section class="c-section c-section--sunken">
    <div class="u-container">
      <h2 class="c-sectiontitle c-sectiontitle--center"><?= e(__('nav.business')) ?></h2>

      <div class="c-grid c-grid--3">
        <?php foreach ($business as $unit): ?>
          <?php $url = $router->url('pages.business', ['slug' => $unit['locale_slug']]); ?>
          <a class="c-card c-card--link" href="<?= e($url) ?>">
            <div class="c-card__media">
              <?php if (!empty($unit['cover_path'])): ?>
                <img src="<?= e($unit['cover_path']) ?>" alt="" loading="lazy">
              <?php endif; ?>
            </div>
            <div class="c-card__body">
              <h3 class="c-card__title"><?= e($unit['title']) ?></h3>
              <p class="c-card__excerpt"><?= e(\Mktr\Core\Html::excerpt((string) $unit['body'], 18)) ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if ($highlights !== []): ?>
  <section class="c-section">
    <div class="u-container">
      <h2 class="c-sectiontitle c-sectiontitle--center"><?= e(__('nav.sustainability')) ?></h2>

      <div class="c-grid c-grid--2">
        <?php foreach ($highlights as $item): ?>
          <?php $url = $router->url('pages.sustainability', ['slug' => $item['locale_slug']]); ?>
          <a class="c-panel" href="<?= e($url) ?>">
            <div class="c-panel__media">
              <?php if (!empty($item['cover_path'])): ?>
                <img src="<?= e($item['cover_path']) ?>" alt="" loading="lazy">
              <?php endif; ?>
            </div>
            <div class="c-panel__body">
              <h3 class="c-panel__title"><?= e($item['title']) ?></h3>
              <p class="c-panel__text"><?= e(\Mktr\Core\Html::excerpt((string) $item['body'], 22)) ?></p>
              <span class="c-panel__more"><?= e(__('news.read_more')) ?> &rarr;</span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if ($posts !== []): ?>
  <section class="c-section c-section--sunken">
    <div class="u-container">
      <div class="c-sectionhead">
        <h2 class="c-sectiontitle"><?= e(__('news.title')) ?></h2>
        <a class="c-btn c-btn--ghost c-btn--sm" href="<?= e($router->url('news.index')) ?>"><?= e(__('news.title')) ?> &rarr;</a>
      </div>

      <div class="c-grid c-grid--3">
        <?php foreach ($posts as $post): ?>
          <?php $url = $router->url('news.show', ['id' => $post['id'], 'slug' => $post['slug']]); ?>
          <a class="c-card c-card--link" href="<?= e($url) ?>">
            <div class="c-card__media">
              <?php if (!empty($post['cover_path'])): ?>
                <img src="<?= e($post['cover_path']) ?>" alt="<?= e($post['cover_alt'] !== null ? $post['cover_alt'] : $post['title']) ?>" loading="lazy">
              <?php endif; ?>
            </div>
            <div class="c-card__body">
              <div class="c-card__meta"><?= e(format_date_id($post['published_at'], $locale)) ?></div>
              <h3 class="c-card__title"><?= e($post['title']) ?></h3>
              <p class="c-card__excerpt"><?= e($post['excerpt']) ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if (count($banners) > 1): ?>
<?php ob_start(); ?>
<script>
(function () {
    'use strict';
    var track = document.getElementById('hero-track');
    var dots  = document.getElementById('hero-dots');
    if (!track || !dots) { return; }

    var slides  = track.children;
    var buttons = dots.querySelectorAll('.c-hero__dot');
    var index   = 0;
    var timer   = null;

    var show = function (next) {
        index = (next + slides.length) % slides.length;
        track.style.transform = 'translateX(-' + (index * 100) + '%)';
        Array.prototype.forEach.call(buttons, function (b, i) {
            b.classList.toggle('is-active', i === index);
            b.setAttribute('aria-selected', i === index ? 'true' : 'false');
        });
    };

    // Respect the visitor's motion preference: no auto-advance if reduced.
    var still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var start = function () { if (!still) { timer = window.setInterval(function () { show(index + 1); }, 7000); } };
    var stop  = function () { if (timer) { window.clearInterval(timer); timer = null; } };

    Array.prototype.forEach.call(buttons, function (button) {
        button.addEventListener('click', function () { stop(); show(parseInt(button.dataset.slide, 10)); start(); });
    });

    track.addEventListener('mouseenter', stop);
    track.addEventListener('mouseleave', start);

    show(0);
    start();
})();
</script>
<?php $scripts = ob_get_clean(); ?>
<?php endif; ?>
