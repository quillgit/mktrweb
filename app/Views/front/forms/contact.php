<?php
/**
 * /kontak_kami
 *
 * The legacy page laid out these fields but never wired them: no <form>, no
 * `name` attributes, and "Kirim Pesan" was an <a href="#">. This one posts.
 *
 * @var array  $page
 * @var array  $subjects
 * @var string $success
 * @var string $error
 * @var array  $formErrors
 */
$layout = 'layouts.front';

$err = function (string $field) use ($formErrors) {
    return isset($formErrors[$field]) ? (string) $formErrors[$field] : '';
};

/* Address, email and the social links are settings, not markup. */
$fallback = (string) config('app.default_locale', 'id');
$settings = new \Mktr\Models\Setting();

$address = $settings->text('contact.address', $locale, $fallback,
    "Gedung Maktour, Jl. Ir. H. Juanda III No. 26,\nJakarta Pusat 10120, Indonesia");
$email   = $settings->text('contact.email', $locale, $fallback, 'corsec@mktr.co.id');
$phone   = $settings->text('contact.phone', $locale, $fallback);

$social = [
    'Instagram' => $settings->text('social.instagram', $locale, $fallback),
    'YouTube'   => $settings->text('social.youtube', $locale, $fallback),
    'Facebook'  => $settings->text('social.facebook', $locale, $fallback),
    'LinkedIn'  => $settings->text('social.linkedin', $locale, $fallback),
];
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => 'contact', 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-contact">
    <aside class="c-contact__aside">
      <h2 class="c-contact__org"><?= e(__('site.name')) ?></h2>

      <h3 class="c-contact__label"><?= e(__('contact.office')) ?></h3>
      <address class="c-contact__text"><?= nl2br(e($address)) ?></address>

      <?php if ($email !== ''): ?>
        <h3 class="c-contact__label">Email</h3>
        <p class="c-contact__text"><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
      <?php endif; ?>

      <?php if ($phone !== ''): ?>
        <h3 class="c-contact__label"><?= e(__('contact.phone')) ?></h3>
        <p class="c-contact__text"><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>"><?= e($phone) ?></a></p>
      <?php endif; ?>

      <h3 class="c-contact__label"><?= e(__('contact.social')) ?></h3>
      <ul class="c-contact__social">
        <?php foreach ($social as $name => $url): ?>
          <?php if ($url === '') { continue; } ?>
          <li><a href="<?= e($url) ?>" target="_blank" rel="noopener noreferrer"><?= e($name) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </aside>

    <div class="c-contact__main">
      <?= partial('partials.front.form-notice', ['success' => $success, 'error' => $error]) ?>

      <p class="c-lead"><?= e(__('contact.lead')) ?></p>

      <form class="c-form" method="post" action="<?= e($router->url('forms.contact.submit')) ?>" novalidate>
        <?= csrf_field() ?>
        <?= partial('partials.front.honeypot') ?>

        <div class="c-field">
          <label class="c-label" for="subject"><?= e(__('contact.subject')) ?> *</label>
          <select class="c-input<?= $err('subject') !== '' ? ' has-error' : '' ?>" id="subject" name="subject" required>
            <?php foreach ($subjects as $option): ?>
              <option value="<?= e($option) ?>" <?= old('subject') === $option ? 'selected' : '' ?>><?= e($option) ?></option>
            <?php endforeach; ?>
          </select>
          <?php if ($err('subject') !== ''): ?><p class="c-error"><?= e($err('subject')) ?></p><?php endif; ?>
        </div>

        <div class="c-field-row">
          <div class="c-field">
            <label class="c-label" for="name"><?= e(__('contact.name')) ?> *</label>
            <input class="c-input<?= $err('name') !== '' ? ' has-error' : '' ?>" type="text" id="name" name="name"
                   value="<?= e(old('name')) ?>" required maxlength="191">
            <?php if ($err('name') !== ''): ?><p class="c-error"><?= e($err('name')) ?></p><?php endif; ?>
          </div>
          <div class="c-field">
            <label class="c-label" for="company"><?= e(__('contact.company')) ?></label>
            <input class="c-input" type="text" id="company" name="company" value="<?= e(old('company')) ?>" maxlength="191">
          </div>
        </div>

        <div class="c-field-row">
          <div class="c-field">
            <label class="c-label" for="email"><?= e(__('contact.email')) ?> *</label>
            <input class="c-input<?= $err('email') !== '' ? ' has-error' : '' ?>" type="email" id="email" name="email"
                   value="<?= e(old('email')) ?>" required maxlength="191">
            <?php if ($err('email') !== ''): ?><p class="c-error"><?= e($err('email')) ?></p><?php endif; ?>
          </div>
          <div class="c-field">
            <label class="c-label" for="phone"><?= e(__('contact.phone')) ?></label>
            <input class="c-input<?= $err('phone') !== '' ? ' has-error' : '' ?>" type="tel" id="phone" name="phone"
                   value="<?= e(old('phone')) ?>" maxlength="40">
            <?php if ($err('phone') !== ''): ?><p class="c-error"><?= e($err('phone')) ?></p><?php endif; ?>
          </div>
        </div>

        <div class="c-field">
          <label class="c-label" for="message"><?= e(__('contact.message')) ?> *</label>
          <textarea class="c-input<?= $err('message') !== '' ? ' has-error' : '' ?>" id="message" name="message"
                    rows="6" required maxlength="5000"><?= e(old('message')) ?></textarea>
          <?php if ($err('message') !== ''): ?><p class="c-error"><?= e($err('message')) ?></p><?php endif; ?>
        </div>

        <p class="c-form__note"><?= e(__('form.required_note')) ?></p>
        <button class="c-btn" type="submit"><?= e(__('form.send')) ?></button>
      </form>
    </div>
  </div>
</section>
