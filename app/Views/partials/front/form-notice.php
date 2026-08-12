<?php
/**
 * Success / error banner shared by the three public forms.
 *
 * @var string $success
 * @var string $error
 */
?>
<?php if ($success !== ''): ?>
  <div class="c-notice c-notice--success" role="status"><?= e($success) ?></div>
<?php endif; ?>
<?php if ($error !== ''): ?>
  <div class="c-notice c-notice--error" role="alert"><?= e($error) ?></div>
<?php endif; ?>
