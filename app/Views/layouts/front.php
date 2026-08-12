<?php
/**
 * Front-end layout.
 *
 * @var string      $content
 * @var string      $locale
 * @var string|null $title
 * @var string|null $metaDescription
 * @var string|null $ogImage
 * @var string|null $canonical
 */

$title           = isset($title) ? $title : __('site.name');
$metaDescription = isset($metaDescription) ? $metaDescription : '';
$ogImage         = isset($ogImage) && $ogImage !== '' ? $ogImage : '/assets/images/resources/3d MKTR.png';
$canonical       = isset($canonical) ? $canonical : '';
$noindex         = isset($noindex) ? (bool) $noindex : false;
$siteUrl         = rtrim((string) config('app.url', ''), '/');
?><!doctype html>
<html lang="<?= e($locale) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= e($title) ?></title>
<?php if ($metaDescription !== ''): ?>
<meta name="description" content="<?= e($metaDescription) ?>">
<?php endif; ?>
<meta name="author" content="<?= e(__('site.name')) ?>">
<meta name="robots" content="<?= $noindex ? 'noindex, nofollow' : 'index, follow' ?>">
<?php if ($canonical !== ''): ?>
<link rel="canonical" href="<?= e($siteUrl . $canonical) ?>">
<?php endif; ?>

<meta property="og:type" content="website">
<meta property="og:site_name" content="mktr.co.id">
<meta property="og:title" content="<?= e($title) ?>">
<?php if ($metaDescription !== ''): ?>
<meta property="og:description" content="<?= e($metaDescription) ?>">
<?php endif; ?>
<meta property="og:image" content="<?= e($siteUrl . $ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">

<link rel="shortcut icon" href="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= e(asset('assets/css/app.css')) ?>">
</head>
<body>

<a class="c-skip" href="#main"><?= e(__('common.skip')) ?></a>

<?= partial('partials.front.header') ?>

<main id="main">
<?= $content ?>
</main>

<?= partial('partials.front.footer') ?>

<script>
// Sticky-header shadow, and the mobile nav toggle. Deliberately tiny — the
// rebuilt front-end has no jQuery and no plugin stack.
(function () {
    var header = document.querySelector('.c-header');
    if (header) {
        var onScroll = function () {
            header.classList.toggle('is-stuck', window.scrollY > 4);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    var toggle = document.querySelector('.c-navtoggle');
    var nav    = document.querySelector('.c-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // Dropdowns open on hover via CSS; this adds keyboard and touch support,
    // which hover alone cannot provide.
    document.querySelectorAll('.c-nav__toggle').forEach(function (button) {
        var item = button.closest('.c-navitem');

        button.addEventListener('click', function () {
            var open = !item.classList.contains('is-open');

            document.querySelectorAll('.c-navitem.is-open').forEach(function (other) {
                if (other !== item) {
                    other.classList.remove('is-open');
                    var otherButton = other.querySelector('.c-nav__toggle');
                    if (otherButton) { otherButton.setAttribute('aria-expanded', 'false'); }
                }
            });

            item.classList.toggle('is-open', open);
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.c-navitem')) {
            document.querySelectorAll('.c-navitem.is-open').forEach(function (item) {
                item.classList.remove('is-open');
                var button = item.querySelector('.c-nav__toggle');
                if (button) { button.setAttribute('aria-expanded', 'false'); }
            });
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') { return; }
        document.querySelectorAll('.c-navitem.is-open').forEach(function (item) {
            item.classList.remove('is-open');
            var button = item.querySelector('.c-nav__toggle');
            if (button) { button.setAttribute('aria-expanded', 'false'); }
        });
    });
})();
</script>
</body>
</html>
