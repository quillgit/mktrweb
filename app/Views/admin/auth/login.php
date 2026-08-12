<?php
/**
 * Login. Standalone — no admin layout.
 *
 * @var string $flashError
 * @var array  $formErrors
 * @var \Mktr\Core\Router $router
 */
?><!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Masuk — CMS MKTR</title>
<link rel="shortcut icon" href="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('assets/css/admin.css')) ?>">
</head>
<body>

<main class="a-login">
  <div class="a-login__card">
    <div class="a-login__brand">
      <img src="<?= e(asset('assets/images/resources/3d MKTR.png')) ?>" alt="">
      <h1>MKTR CMS</h1>
      <p>PT Menthobi Karyatama Raya Tbk</p>
    </div>

    <?php if ($flashError !== ''): ?>
      <div class="a-notice a-notice--error" role="alert"><?= e($flashError) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e($router->url('admin.login.post')) ?>" novalidate>
      <?= csrf_field() ?>

      <div class="a-field">
        <label class="a-label" for="username">Nama pengguna</label>
        <input class="a-input<?= isset($formErrors['username']) ? ' has-error' : '' ?>"
               type="text" id="username" name="username"
               value="<?= e(old('username')) ?>"
               autocomplete="username" autofocus required>
        <?php if (isset($formErrors['username'])): ?>
          <p class="a-error"><?= e($formErrors['username']) ?></p>
        <?php endif; ?>
      </div>

      <div class="a-field">
        <label class="a-label" for="password">Kata sandi</label>
        <input class="a-input<?= isset($formErrors['password']) ? ' has-error' : '' ?>"
               type="password" id="password" name="password"
               autocomplete="current-password" required>
        <?php if (isset($formErrors['password'])): ?>
          <p class="a-error"><?= e($formErrors['password']) ?></p>
        <?php endif; ?>
      </div>

      <button class="a-btn" type="submit" style="width:100%">Masuk</button>
    </form>
  </div>
</main>

</body>
</html>
