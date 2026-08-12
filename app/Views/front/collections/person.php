<?php
/**
 * /mktr_so/{slug} — a single member of the board.
 *
 * Full width rather than the section sidebar, as in the legacy page: the
 * biography is the content, and the board it belongs to is one click away in
 * the breadcrumb and again below.
 *
 * @var array  $person
 * @var array  $colleagues
 * @var string $boardLabel
 * @var string $boardUrl
 * @var array  $page
 * @var string $section
 */
$layout = 'layouts.front';

$portrait = !empty($person['detail_path']) ? $person['detail_path'] : $person['image_path'];
?>
<section class="c-pagehead c-pagehead--slim">
  <div class="c-pagehead__media">
    <img src="<?= e(asset('assets/images/backgrounds/background-min.jpg')) ?>" alt="" aria-hidden="true">
  </div>
  <div class="u-container c-pagehead__inner">
    <ul class="c-breadcrumb">
      <li><a href="<?= e($router->url('home')) ?>"><?= e(__('nav.home')) ?></a></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li><a href="<?= e($boardUrl) ?>"><?= e($boardLabel) ?></a></li>
      <li class="c-breadcrumb__sep" aria-hidden="true">/</li>
      <li aria-current="page"><?= e($person['title']) ?></li>
    </ul>
    <h1 class="c-pagehead__title"><?= e($person['title']) ?></h1>
    <?php if (!empty($person['subtitle'])): ?>
      <p class="c-pagehead__lead"><?= e($person['subtitle']) ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="c-section">
  <div class="u-container c-profile">
    <div class="c-profile__photo">
      <?php if (!empty($portrait)): ?>
        <img src="<?= e($portrait) ?>" alt="<?= e($person['title']) ?>">
      <?php endif; ?>
    </div>

    <div class="c-profile__body">
      <h2 class="c-profile__name"><?= e($person['title']) ?></h2>
      <?php if (!empty($person['subtitle'])): ?>
        <p class="c-profile__role"><?= e($person['subtitle']) ?></p>
      <?php endif; ?>

      <?php if (!empty($person['body'])): ?>
        <?php /* Sanitised on import and on save by Mktr\Core\Html::sanitize(). */ ?>
        <div class="c-prose"><?= $person['body'] ?></div>
      <?php endif; ?>

      <p style="margin-top:28px">
        <a class="c-btn c-btn--ghost c-btn--sm" href="<?= e($boardUrl) ?>">&larr; <?= e($boardLabel) ?></a>
      </p>
    </div>
  </div>
</section>

<?php if ($colleagues !== []): ?>
  <section class="c-section c-section--sunken c-section--tight">
    <div class="u-container">
      <p class="c-eyebrow"><?= e(__('collections.others')) ?></p>
      <div class="c-people">
        <?php foreach ($colleagues as $colleague): ?>
          <?php $url = $router->url('collections.person', ['slug' => $colleague['slug']]); ?>
          <article class="c-person">
            <a class="c-person__link" href="<?= e($url) ?>">
              <div class="c-person__photo">
                <?php if (!empty($colleague['image_path'])): ?>
                  <img src="<?= e($colleague['image_path']) ?>" alt="<?= e($colleague['title']) ?>" loading="lazy">
                <?php endif; ?>
              </div>
              <div class="c-person__body">
                <h3 class="c-person__name"><?= e($colleague['title']) ?></h3>
                <?php if (!empty($colleague['subtitle'])): ?>
                  <p class="c-person__role"><?= e($colleague['subtitle']) ?></p>
                <?php endif; ?>
              </div>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
