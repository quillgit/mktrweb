<?php
/**
 * @var array|null $job
 * @var array $translations
 * @var array|null $cover
 * @var array $formErrors
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$isEdit  = $job !== null;
$heading = $isEdit ? 'Sunting Lowongan' : 'Tambah Lowongan';
$locales = (array) config('app.locales', ['id']);
$default = (string) config('app.default_locale', 'id');
$names   = (array) config('app.locale_names', []);

$action = $isEdit
    ? $router->url('admin.careers.update', ['id' => $job['id']])
    : $router->url('admin.careers.store');

$value = function (string $field, string $locale = '') use ($translations) {
    $key = $locale === '' ? $field : $field . '_' . $locale;
    $old = old($key, null);
    if ($old !== null) { return (string) $old; }
    if ($locale !== '' && isset($translations[$locale][$field])) { return (string) $translations[$locale][$field]; }
    return '';
};

$status      = old('status', $isEdit ? $job['status'] : 'draft');
$closesOn    = old('closes_on', $isEdit && $job['closes_on'] !== null ? $job['closes_on'] : '');
$publishedAt = old('published_at', $isEdit && $job['published_at'] !== null
    ? date('Y-m-d\TH:i', (int) strtotime((string) $job['published_at'])) : '');
$coverId = (int) old('cover_media_id', $isEdit && $job['cover_media_id'] !== null ? $job['cover_media_id'] : 0);
?>
<form method="post" action="<?= e($action) ?>">
  <?= csrf_field() ?>
  <div class="a-grid a-grid--sidebar">
    <div>
      <div class="a-panel">
        <div class="a-panel__body">
          <div class="a-tabs" role="tablist">
            <?php foreach ($locales as $i => $code): ?>
              <button class="a-tab<?= $i === 0 ? ' is-active' : '' ?>" type="button" role="tab"
                      data-tab="<?= e($code) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
                <?= e(isset($names[$code]) ? $names[$code] : strtoupper($code)) ?><?= $code === $default ? ' *' : '' ?>
              </button>
            <?php endforeach; ?>
          </div>
          <?php foreach ($locales as $i => $code): ?>
            <div class="a-tabpanel" data-panel="<?= e($code) ?>" <?= $i === 0 ? '' : 'hidden' ?>>
              <div class="a-field">
                <label class="a-label" for="title_<?= e($code) ?>">Judul<?= $code === $default ? ' (wajib)' : '' ?></label>
                <input class="a-input<?= isset($formErrors['title_' . $code]) ? ' has-error' : '' ?>" type="text"
                       id="title_<?= e($code) ?>" name="title_<?= e($code) ?>" value="<?= e($value('title', $code)) ?>">
                <?php if (isset($formErrors['title_' . $code])): ?><p class="a-error"><?= e($formErrors['title_' . $code]) ?></p><?php endif; ?>
              </div>
              <div class="a-field">
                <label class="a-label" for="body_<?= e($code) ?>">Deskripsi pekerjaan</label>
                <textarea class="a-richtext" id="body_<?= e($code) ?>" name="body_<?= e($code) ?>"><?= e($value('body', $code)) ?></textarea>
              </div>
              <div class="a-field" style="margin-bottom:0">
                <label class="a-label" for="meta_description_<?= e($code) ?>">Meta description</label>
                <textarea class="a-textarea" id="meta_description_<?= e($code) ?>" name="meta_description_<?= e($code) ?>" rows="2"><?= e($value('meta_description', $code)) ?></textarea>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div>
      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Publikasi</h2></div>
        <div class="a-panel__body">
          <div class="a-field">
            <label class="a-label" for="status">Status</label>
            <select class="a-select" id="status" name="status">
              <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Draf</option>
              <option value="scheduled" <?= $status === 'scheduled' ? 'selected' : '' ?>>Terjadwal</option>
              <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Terbit</option>
            </select>
          </div>
          <div class="a-field" id="published-at-field">
            <label class="a-label" for="published_at">Waktu publikasi</label>
            <input class="a-input" type="datetime-local" id="published_at" name="published_at" value="<?= e($publishedAt) ?>">
          </div>
          <div class="a-field">
            <label class="a-label" for="location">Lokasi</label>
            <input class="a-input" type="text" id="location" name="location"
                   value="<?= e(old('location', $isEdit && $job['location'] !== null ? $job['location'] : '')) ?>">
          </div>
          <div class="a-field">
            <label class="a-label" for="closes_on">Tanggal penutupan</label>
            <input class="a-input" type="date" id="closes_on" name="closes_on" value="<?= e($closesOn) ?>">
            <p class="a-hint">Lowongan otomatis hilang dari daftar setelah tanggal ini.</p>
          </div>
          <div class="a-field" style="margin-bottom:0">
            <label class="a-label" for="slug">Slug URL</label>
            <input class="a-input" type="text" id="slug" name="slug"
                   value="<?= e(old('slug', $isEdit ? $job['slug'] : '')) ?>" placeholder="dibuat otomatis dari judul">
          </div>
        </div>
        <div class="a-panel__head" style="border-top:1px solid var(--ink-200);border-bottom:0">
          <button class="a-btn" type="submit">Simpan</button>
          <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.careers.index')) ?>">Kembali</a>
        </div>
      </div>

      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Gambar</h2></div>
        <div class="a-panel__body">
          <input type="hidden" name="cover_media_id" id="cover_media_id" value="<?= $coverId ?>" data-preview="cover-preview">
          <div class="a-cover-preview" id="cover-preview" <?= $cover === null ? 'hidden' : '' ?>>
            <img data-preview-image src="<?= e($cover !== null ? $cover['path'] : '') ?>" alt="">
          </div>
          <div class="a-actions">
            <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-open-media="cover_media_id" data-media-kind="image">Pilih gambar</button>
            <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-clear-media="cover_media_id" <?= $cover === null ? 'hidden' : '' ?>>Hapus</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?php ob_start(); ?>
<script src="<?= e(asset('assets/vendor/tinymce/tinymce.min.js')) ?>"></script>
<script>
(function () {
    'use strict';
    var tabs = document.querySelectorAll('.a-tab');
    Array.prototype.forEach.call(tabs, function (tab) {
        tab.addEventListener('click', function () {
            var code = tab.dataset.tab;
            Array.prototype.forEach.call(tabs, function (t) {
                var on = t === tab;
                t.classList.toggle('is-active', on);
                t.setAttribute('aria-selected', on ? 'true' : 'false');
            });
            document.querySelectorAll('.a-tabpanel').forEach(function (p) { p.hidden = p.dataset.panel !== code; });
        });
    });

    var statusSelect = document.getElementById('status');
    var publishField = document.getElementById('published-at-field');
    var sync = function () { publishField.hidden = statusSelect.value === 'draft'; };
    statusSelect.addEventListener('change', sync);
    sync();

    tinymce.init({
        selector: 'textarea.a-richtext',
        license_key: 'gpl',
        base_url: <?= json_encode(asset('assets/vendor/tinymce')) ?>,
        height: 460, menubar: false, branding: false, promotion: false,
        plugins: 'lists link image table code searchreplace fullscreen autolink charmap wordcount',
        toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image table | blockquote removeformat | code fullscreen',
        block_formats: 'Paragraf=p; Judul 2=h2; Judul 3=h3; Judul 4=h4',
        content_style: 'body{font-family:Archivo,system-ui,sans-serif;font-size:16px;line-height:1.7;color:#2C3833}',
        convert_urls: false,
        file_picker_types: 'image',
        file_picker_callback: function (callback) {
            window.MktrMediaPicker.open({ kind: 'image', onPick: function (item) { callback(item.path, { alt: item.alt || item.filename }); } });
        }
    });
})();
</script>
<?php $scripts = partial('partials.admin.media-picker') . ob_get_clean(); ?>
