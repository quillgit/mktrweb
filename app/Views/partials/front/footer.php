<?php
/** @var \Mktr\Core\Router $router */
?>
<footer class="c-footer">
  <div class="u-container">
    <div class="c-footer__grid">
      <div>
        <h3><?= e(__('nav.about')) ?></h3>
        <ul>
          <li><span><?= e(__('nav.about')) ?></span></li>
          <li><span><?= e(__('nav.business')) ?></span></li>
          <li><span><?= e(__('nav.sustainability')) ?></span></li>
          <li><span><?= e(__('nav.governance')) ?></span></li>
        </ul>
      </div>

      <div>
        <h3><?= e(__('nav.investor')) ?></h3>
        <ul>
          <li><a href="<?= e($router->url('news.index')) ?>"><?= e(__('nav.news')) ?></a></li>
          <li><span><?= e(__('nav.career')) ?></span></li>
        </ul>
      </div>

      <div>
        <h3><?= e(__('nav.sustainability')) ?></h3>
        <ul>
          <li><span><?= e(__('nav.sustainability')) ?></span></li>
          <li><span><?= e(__('nav.governance')) ?></span></li>
        </ul>
      </div>

      <div>
        <h3><?= e(__('nav.contact')) ?></h3>
        <p>Gedung Maktour, Jl. Ir. H. Juanda III No.&nbsp;26,<br>Jakarta Pusat 10120, Indonesia</p>
        <p><a href="mailto:corsec@mktr.co.id">corsec@mktr.co.id</a></p>
      </div>
    </div>

    <div class="c-footer__bottom">
      <span>&copy; <?= date('Y') ?> <?= e(__('site.name')) ?></span>
      <span>IDX: MKTR</span>
    </div>
  </div>
</footer>
