<?php
/**
 * /form_grievance
 *
 * Sits in the sustainability section, next to the public register — the same
 * placement as the legacy page, which carried a "Daftar Keluhan" link to it.
 *
 * @var array  $page
 * @var array  $navItems
 * @var string $activeKey
 * @var string $section
 * @var string $success
 * @var string $error
 * @var array  $formErrors
 */
$layout = 'layouts.front';

$err = function (string $field) use ($formErrors) {
    return isset($formErrors[$field]) ? (string) $formErrors[$field] : '';
};

$field = function (string $name, string $label, string $type = 'text') use ($err) {
    return ['name' => $name, 'label' => $label, 'type' => $type, 'error' => $err($name)];
};

$fields = [
    $field('name', __('grievance.name')),
    $field('organization', __('grievance.occupation')),
    $field('email', __('grievance.email'), 'email'),
    $field('phone', __('grievance.phone'), 'tel'),
    $field('communication', __('grievance.language')),
];
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => $section, 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-pagelayout">
    <aside class="c-pagelayout__side">
      <?= partial('partials.front.section-nav', [
          'navItems' => $navItems, 'activeKey' => $activeKey, 'section' => $section,
      ]) ?>
    </aside>

    <div class="c-pagelayout__main">
      <?= partial('partials.front.form-notice', ['success' => $success, 'error' => $error]) ?>

      <p class="c-lead"><?= e(__('grievance.lead')) ?></p>

      <form class="c-form" method="post" action="<?= e($router->url('forms.grievance.submit')) ?>" novalidate>
        <?= csrf_field() ?>
        <?= partial('partials.front.honeypot') ?>

        <?php foreach ($fields as $f): ?>
          <div class="c-field">
            <label class="c-label" for="<?= e($f['name']) ?>"><?= e($f['label']) ?> *</label>
            <input class="c-input<?= $f['error'] !== '' ? ' has-error' : '' ?>" type="<?= e($f['type']) ?>"
                   id="<?= e($f['name']) ?>" name="<?= e($f['name']) ?>"
                   value="<?= e(old($f['name'])) ?>" required>
            <?php if ($f['error'] !== ''): ?><p class="c-error"><?= e($f['error']) ?></p><?php endif; ?>
          </div>
        <?php endforeach; ?>

        <div class="c-field">
          <label class="c-label" for="address"><?= e(__('grievance.address')) ?> *</label>
          <textarea class="c-input<?= $err('address') !== '' ? ' has-error' : '' ?>" id="address" name="address"
                    rows="4" required maxlength="2000"><?= e(old('address')) ?></textarea>
          <?php if ($err('address') !== ''): ?><p class="c-error"><?= e($err('address')) ?></p><?php endif; ?>
        </div>

        <p class="c-form__note"><?= e(__('form.required_note')) ?></p>
        <p class="c-form__note"><?= e(__('form.privacy')) ?></p>
        <button class="c-btn" type="submit"><?= e(__('form.send')) ?></button>
      </form>
    </div>
  </div>
</section>
