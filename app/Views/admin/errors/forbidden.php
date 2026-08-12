<?php
/**
 * @var array $user
 * @var \Mktr\Core\Router $router
 */

$layout    = 'layouts.admin';
$heading   = 'Akses Ditolak';
$authUser  = $user;
?>
<div class="a-panel">
  <div class="a-panel__body a-empty">
    <h2>Anda tidak memiliki akses ke halaman ini</h2>
    <p>Peran <strong><?= e(isset($user['role_name']) ? $user['role_name'] : '—') ?></strong>
       tidak diizinkan melakukan tindakan tersebut. Hubungi administrator bila Anda memerlukan akses.</p>
    <p style="margin-top:20px">
      <a class="a-btn" href="<?= e($router->url('admin.dashboard')) ?>">Kembali ke Dasbor</a>
    </p>
  </div>
</div>
