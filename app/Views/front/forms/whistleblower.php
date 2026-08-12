<?php
/**
 * /pelaporan_pelanggaran
 *
 * @var array  $page
 * @var array  $categories
 * @var string $success
 * @var string $error
 * @var array  $formErrors
 */
$layout = 'layouts.front';

$err = function (string $field) use ($formErrors) {
    return isset($formErrors[$field]) ? (string) $formErrors[$field] : '';
};

$chosen = (array) old('categories', []);
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => 'governance', 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-formpage">
    <?= partial('partials.front.form-notice', ['success' => $success, 'error' => $error]) ?>

    <p class="c-lead"><?= e(__('whistle.lead')) ?></p>

    <form class="c-form" method="post" action="<?= e($router->url('forms.whistleblower.submit')) ?>" novalidate>
      <?= csrf_field() ?>
      <?= partial('partials.front.honeypot') ?>

      <fieldset class="c-fieldset">
        <legend class="c-legend"><?= e(__('whistle.reporter')) ?></legend>

        <div class="c-field">
          <label class="c-label" for="name"><?= e(__('whistle.reporter_name')) ?></label>
          <input class="c-input" type="text" id="name" name="name" value="<?= e(old('name')) ?>" maxlength="191">
        </div>

        <div class="c-field-row">
          <div class="c-field">
            <label class="c-label" for="phone"><?= e(__('whistle.reporter_phone')) ?> *</label>
            <input class="c-input<?= $err('phone') !== '' ? ' has-error' : '' ?>" type="tel" id="phone" name="phone"
                   value="<?= e(old('phone')) ?>" required maxlength="40">
            <?php if ($err('phone') !== ''): ?><p class="c-error"><?= e($err('phone')) ?></p><?php endif; ?>
          </div>
          <div class="c-field">
            <label class="c-label" for="email"><?= e(__('whistle.reporter_email')) ?> *</label>
            <input class="c-input<?= $err('email') !== '' ? ' has-error' : '' ?>" type="email" id="email" name="email"
                   value="<?= e(old('email')) ?>" required maxlength="191">
            <?php if ($err('email') !== ''): ?><p class="c-error"><?= e($err('email')) ?></p><?php endif; ?>
          </div>
        </div>
      </fieldset>

      <fieldset class="c-fieldset">
        <legend class="c-legend"><?= e(__('whistle.categories')) ?></legend>
        <div class="c-checks">
          <?php foreach ($categories as $i => $category): ?>
            <label class="c-check" for="cat<?= (int) $i ?>">
              <input type="checkbox" id="cat<?= (int) $i ?>" name="categories[]" value="<?= e($category) ?>"
                     <?= in_array($category, $chosen, true) ? 'checked' : '' ?>>
              <span><?= e($category) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <fieldset class="c-fieldset">
        <legend class="c-legend"><?= e(__('whistle.reported')) ?></legend>

        <div class="c-field-row">
          <div class="c-field">
            <label class="c-label" for="reported_name"><?= e(__('whistle.reported_name')) ?> *</label>
            <input class="c-input<?= $err('reported_name') !== '' ? ' has-error' : '' ?>" type="text"
                   id="reported_name" name="reported_name" value="<?= e(old('reported_name')) ?>" required maxlength="191">
            <?php if ($err('reported_name') !== ''): ?><p class="c-error"><?= e($err('reported_name')) ?></p><?php endif; ?>
          </div>
          <div class="c-field">
            <label class="c-label" for="reported_position"><?= e(__('whistle.reported_position')) ?></label>
            <input class="c-input" type="text" id="reported_position" name="reported_position"
                   value="<?= e(old('reported_position')) ?>" maxlength="191">
          </div>
        </div>

        <div class="c-field-row">
          <div class="c-field">
            <label class="c-label" for="occurred_at"><?= e(__('whistle.occurred_at')) ?> *</label>
            <input class="c-input<?= $err('occurred_at') !== '' ? ' has-error' : '' ?>" type="date"
                   id="occurred_at" name="occurred_at" value="<?= e(old('occurred_at')) ?>" required>
            <?php if ($err('occurred_at') !== ''): ?><p class="c-error"><?= e($err('occurred_at')) ?></p><?php endif; ?>
          </div>
          <div class="c-field">
            <label class="c-label" for="location"><?= e(__('whistle.location')) ?> *</label>
            <input class="c-input<?= $err('location') !== '' ? ' has-error' : '' ?>" type="text"
                   id="location" name="location" value="<?= e(old('location')) ?>" required maxlength="255">
            <?php if ($err('location') !== ''): ?><p class="c-error"><?= e($err('location')) ?></p><?php endif; ?>
          </div>
        </div>

        <div class="c-field">
          <label class="c-label" for="message"><?= e(__('whistle.chronology')) ?> *</label>
          <textarea class="c-input<?= $err('message') !== '' ? ' has-error' : '' ?>" id="message" name="message"
                    rows="7" required maxlength="8000"><?= e(old('message')) ?></textarea>
          <?php if ($err('message') !== ''): ?><p class="c-error"><?= e($err('message')) ?></p><?php endif; ?>
        </div>

        <div class="c-field">
          <label class="c-label" for="amount"><?= e(__('whistle.amount')) ?></label>
          <input class="c-input<?= $err('amount') !== '' ? ' has-error' : '' ?>" type="number" min="0" step="1"
                 id="amount" name="amount" value="<?= e(old('amount')) ?>">
          <?php if ($err('amount') !== ''): ?><p class="c-error"><?= e($err('amount')) ?></p><?php endif; ?>
        </div>
      </fieldset>

      <p class="c-form__note"><?= e(__('form.required_note')) ?></p>
      <p class="c-form__note"><?= e(__('form.privacy')) ?></p>
      <button class="c-btn" type="submit"><?= e(__('form.send')) ?></button>
    </form>
  </div>
</section>
