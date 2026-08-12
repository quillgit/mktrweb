<?php
/** @var \Mktr\Core\Router $router */
$layout  = 'layouts.front';
$title   = __('error.419.title') . ' — ' . __('site.name');
$noindex = true;
?>
<section class="c-section" style="text-align:center">
  <div class="u-container">
    <p style="font-size:clamp(72px,14vw,150px);line-height:1;font-weight:700;color:var(--green-500);margin:0 0 8px">419</p>
    <h1 class="c-section__title"><?= e(__('error.419.title')) ?></h1>
    <p class="c-section__lead" style="margin:0 auto 28px"><?= e(__('error.419.body')) ?></p>
    <a class="c-btn" href="<?= e($router->url('home')) ?>"><?= e(__('error.back_home')) ?></a>
  </div>
</section>
