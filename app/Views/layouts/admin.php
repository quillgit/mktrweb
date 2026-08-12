<?php
/**
 * @var string $content
 * @var array  $authUser
 * @var string $title
 * @var \Mktr\Core\Router  $router
 * @var \Mktr\Core\Request $request
 */

$title   = isset($title) ? $title : 'CMS MKTR';
$current = $request->path();

$isActive = function (string $needle) use ($current) {
    return strpos($current, $needle) !== false;
};
?><!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title) ?></title>
<link rel="shortcut icon" href="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('assets/css/admin.css')) ?>">
</head>
<body>

<div class="a-shell">
  <aside class="a-side">
    <a class="a-side__brand" href="<?= e($router->url('admin.dashboard')) ?>">
      <img src="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>" alt="">
      <strong>MKTR CMS</strong>
    </a>

    <nav class="a-side__nav" aria-label="Navigasi CMS">
      <div class="a-side__label">Konten</div>
      <?php
      $sections  = ['/admin/pages', '/admin/posts', '/admin/documents', '/admin/careers', '/admin/media'];
      $inSection = false;
      foreach ($sections as $path) {
          if ($isActive($path)) {
              $inSection = true;
              break;
          }
      }
      ?>
      <a class="a-side__link<?= $isActive('/admin') && !$inSection ? ' is-active' : '' ?>"
         href="<?= e($router->url('admin.dashboard')) ?>">Dasbor</a>
      <a class="a-side__link<?= $isActive('/admin/pages') ? ' is-active' : '' ?>"
         href="<?= e($router->url('admin.pages.index')) ?>">Halaman</a>
      <a class="a-side__link<?= $isActive('/admin/posts') ? ' is-active' : '' ?>"
         href="<?= e($router->url('admin.posts.index')) ?>">Berita &amp; Kegiatan</a>
      <a class="a-side__link<?= $isActive('/admin/documents') ? ' is-active' : '' ?>"
         href="<?= e($router->url('admin.documents.index')) ?>">Dokumen Investor</a>
      <a class="a-side__link<?= $isActive('/admin/careers') ? ' is-active' : '' ?>"
         href="<?= e($router->url('admin.careers.index')) ?>">Karir</a>
      <a class="a-side__link<?= $isActive('/admin/media') ? ' is-active' : '' ?>"
         href="<?= e($router->url('admin.media.index')) ?>">Pustaka Media</a>

      <div class="a-side__label">Segera hadir</div>
      <a class="a-side__link" href="#" aria-disabled="true" style="opacity:.45;cursor:not-allowed">Formulir &amp; Pesan</a>
      <a class="a-side__link" href="#" aria-disabled="true" style="opacity:.45;cursor:not-allowed">Pengguna</a>
    </nav>
  </aside>

  <div class="a-main">
    <header class="a-top">
      <h1 class="a-top__title"><?= e(isset($heading) ? $heading : 'CMS') ?></h1>
      <div class="a-top__user">
        <a href="<?= e($router->url('news.index')) ?>" target="_blank" rel="noopener">Lihat situs &nearr;</a>
        <span><?= e(isset($authUser['name']) ? $authUser['name'] : '') ?></span>
        <span class="a-badge-role"><?= e(isset($authUser['role_name']) ? $authUser['role_name'] : '') ?></span>
        <form method="post" action="<?= e($router->url('admin.logout')) ?>" class="u-inline">
          <?= csrf_field() ?>
          <button class="a-btn a-btn--ghost a-btn--sm" type="submit">Keluar</button>
        </form>
      </div>
    </header>

    <div class="a-body">
      <?php if (!empty($flashSuccess)): ?>
        <div class="a-notice a-notice--success" role="status"><?= e($flashSuccess) ?></div>
      <?php endif; ?>
      <?php if (!empty($flashError)): ?>
        <div class="a-notice a-notice--error" role="alert"><?= e($flashError) ?></div>
      <?php endif; ?>

      <?= $content ?>
    </div>
  </div>
</div>

<script>
// Confirm destructive actions. Every delete is a POST with a CSRF token, so a
// stray GET can never remove content.
document.addEventListener('submit', function (event) {
    var form = event.target;
    if (form.dataset && form.dataset.confirm && !window.confirm(form.dataset.confirm)) {
        event.preventDefault();
    }
});
</script>
<?= isset($scripts) ? $scripts : '' ?>
</body>
</html>
