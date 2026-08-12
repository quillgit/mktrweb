<?php
/**
 * Editor for the six collections. The fields only some kinds use are shown per
 * kind rather than split across six near-identical screens.
 *
 * @var array|null $item
 * @var string $kind
 * @var array  $labels
 * @var array  $groups
 * @var array  $translations
 * @var array|null $image
 * @var array|null $detailImage
 * @var array|null $mobileImage
 * @var array  $formErrors
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$isEdit  = $item !== null;
$heading = ($isEdit ? 'Sunting ' : 'Tambah ') . $labels[$kind][0];
$locales = (array) config('app.locales', ['id']);
$default = (string) config('app.default_locale', 'id');
$names   = (array) config('app.locale_names', []);

$action = $isEdit
    ? $router->url('admin.collections.update', ['id' => $item['id']])
    : $router->url('admin.collections.store');

$value = function (string $field, string $locale = '') use ($translations) {
    $key = $locale === '' ? $field : $field . '_' . $locale;
    $old = old($key, null);
    if ($old !== null) { return (string) $old; }
    if ($locale !== '' && isset($translations[$locale][$field])) { return (string) $translations[$locale][$field]; }
    return '';
};

$currentKind = (string) old('kind', $kind);
$status      = old('status', $isEdit ? $item['status'] : 'draft');
$group       = old('group_key', $isEdit && $item['group_key'] !== null ? $item['group_key'] : '');

$mediaId = function (string $field) use ($isEdit, $item) {
    return (int) old($field, $isEdit && $item[$field] !== null ? $item[$field] : 0);
};

/* Which optional fields this kind actually uses. */
$hasGroup  = $currentKind === 'leadership';
$hasDetail = $currentKind === 'leadership';
$hasMobile = $currentKind === 'banner';
$hasLink   = in_array($currentKind, ['membership', 'award', 'subsidiary', 'banner'], true);

$subtitleHint = [
    'leadership' => 'Jabatan, misalnya "Komisaris Utama".',
    'subsidiary' => 'Bidang usaha, ditampilkan di bawah nama perusahaan.',
    'milestone'  => 'Judul adalah tahun; sub judul adalah nama entitas.',
][$currentKind] ?? '';
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
                <label class="a-label" for="subtitle_<?= e($code) ?>">Sub judul</label>
                <input class="a-input" type="text" id="subtitle_<?= e($code) ?>"
                       name="subtitle_<?= e($code) ?>" value="<?= e($value('subtitle', $code)) ?>">
                <?php if ($subtitleHint !== ''): ?><p class="a-hint"><?= e($subtitleHint) ?></p><?php endif; ?>
              </div>
              <div class="a-field" style="margin-bottom:0">
                <label class="a-label" for="body_<?= e($code) ?>">Isi</label>
                <textarea class="a-richtext" id="body_<?= e($code) ?>" name="body_<?= e($code) ?>"><?= e($value('body', $code)) ?></textarea>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div>
      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Pengaturan</h2></div>
        <div class="a-panel__body">
          <div class="a-field">
            <label class="a-label" for="kind">Jenis</label>
            <select class="a-select" id="kind" name="kind" <?= $isEdit ? 'disabled' : '' ?>>
              <?php foreach ($labels as $key => $label): ?>
                <option value="<?= e($key) ?>" <?= $currentKind === $key ? 'selected' : '' ?>><?= e($label[1]) ?></option>
              <?php endforeach; ?>
            </select>
            <?php if ($isEdit): ?>
              <?php /* Changing the kind would move the row to another page and
                       orphan its URL, so it is fixed after creation. */ ?>
              <input type="hidden" name="kind" value="<?= e($currentKind) ?>">
              <p class="a-hint">Jenis tidak dapat diubah setelah data dibuat.</p>
            <?php endif; ?>
          </div>

          <div class="a-field" id="group-field" <?= $hasGroup ? '' : 'hidden' ?>>
            <label class="a-label" for="group_key">Kelompok</label>
            <select class="a-select" id="group_key" name="group_key">
              <option value="">— tidak dikelompokkan —</option>
              <?php foreach ($groups as $key => $label): ?>
                <option value="<?= e($key) ?>" <?= $group === $key ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
            <p class="a-hint">Menentukan halaman tempat orang ini tampil.</p>
          </div>

          <div class="a-field">
            <label class="a-label" for="status">Status</label>
            <select class="a-select" id="status" name="status">
              <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Draf</option>
              <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Terbit</option>
            </select>
          </div>

          <div class="a-field">
            <label class="a-label" for="sort">Urutan</label>
            <input class="a-input" type="number" id="sort" name="sort"
                   value="<?= e((string) old('sort', $isEdit ? $item['sort'] : 0)) ?>">
            <p class="a-hint">Angka kecil tampil lebih dahulu.</p>
          </div>

          <div class="a-field" id="link-field" <?= $hasLink ? '' : 'hidden' ?>>
            <label class="a-label" for="link">Tautan</label>
            <input class="a-input<?= isset($formErrors['link']) ? ' has-error' : '' ?>" type="text" id="link" name="link"
                   value="<?= e(old('link', $isEdit && $item['link'] !== null ? $item['link'] : '')) ?>">
            <?php if (isset($formErrors['link'])): ?><p class="a-error"><?= e($formErrors['link']) ?></p><?php endif; ?>
          </div>

          <div class="a-field" style="margin-bottom:0">
            <label class="a-label" for="slug">Slug URL</label>
            <input class="a-input" type="text" id="slug" name="slug"
                   value="<?= e(old('slug', $isEdit && $item['slug'] !== null ? $item['slug'] : '')) ?>"
                   placeholder="dibuat otomatis dari judul">
          </div>
        </div>
        <div class="a-panel__head" style="border-top:1px solid var(--ink-200);border-bottom:0">
          <button class="a-btn" type="submit">Simpan</button>
          <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.collections.index')) ?>">Kembali</a>
        </div>
      </div>

      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Gambar</h2></div>
        <div class="a-panel__body">
          <div class="a-field">
            <label class="a-label">Gambar utama</label>
            <input type="hidden" name="image_media_id" id="image_media_id"
                   value="<?= $mediaId('image_media_id') ?>" data-preview="image-preview">
            <div class="a-cover-preview" id="image-preview" <?= $image === null ? 'hidden' : '' ?>>
              <img data-preview-image src="<?= e($image !== null ? $image['path'] : '') ?>" alt="">
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-open-media="image_media_id" data-media-kind="image">Pilih</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-clear-media="image_media_id" <?= $image === null ? 'hidden' : '' ?>>Hapus</button>
            </div>
          </div>

          <div class="a-field" id="detail-field" <?= $hasDetail ? '' : 'hidden' ?>>
            <label class="a-label">Foto halaman detail</label>
            <input type="hidden" name="detail_image_media_id" id="detail_image_media_id"
                   value="<?= $mediaId('detail_image_media_id') ?>" data-preview="detail-preview">
            <div class="a-cover-preview" id="detail-preview" <?= $detailImage === null ? 'hidden' : '' ?>>
              <img data-preview-image src="<?= e($detailImage !== null ? $detailImage['path'] : '') ?>" alt="">
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-open-media="detail_image_media_id" data-media-kind="image">Pilih</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-clear-media="detail_image_media_id" <?= $detailImage === null ? 'hidden' : '' ?>>Hapus</button>
            </div>
          </div>

          <div class="a-field" id="mobile-field" style="margin-bottom:0" <?= $hasMobile ? '' : 'hidden' ?>>
            <label class="a-label">Gambar versi ponsel</label>
            <input type="hidden" name="mobile_image_media_id" id="mobile_image_media_id"
                   value="<?= $mediaId('mobile_image_media_id') ?>" data-preview="mobile-preview">
            <div class="a-cover-preview" id="mobile-preview" <?= $mobileImage === null ? 'hidden' : '' ?>>
              <img data-preview-image src="<?= e($mobileImage !== null ? $mobileImage['path'] : '') ?>" alt="">
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-open-media="mobile_image_media_id" data-media-kind="image">Pilih</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-clear-media="mobile_image_media_id" <?= $mobileImage === null ? 'hidden' : '' ?>>Hapus</button>
            </div>
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

    // Show only the fields the selected kind uses.
    var kindSelect = document.getElementById('kind');
    var LINK_KINDS = ['membership', 'award', 'subsidiary', 'banner'];
    var syncKind = function () {
        var kind = kindSelect.value;
        document.getElementById('group-field').hidden  = kind !== 'leadership';
        document.getElementById('detail-field').hidden = kind !== 'leadership';
        document.getElementById('mobile-field').hidden = kind !== 'banner';
        document.getElementById('link-field').hidden   = LINK_KINDS.indexOf(kind) === -1;
    };
    if (!kindSelect.disabled) {
        kindSelect.addEventListener('change', syncKind);
        syncKind();
    }

    tinymce.init({
        selector: 'textarea.a-richtext',
        license_key: 'gpl',
        base_url: <?= json_encode(asset('assets/vendor/tinymce')) ?>,
        height: 340, menubar: false, branding: false, promotion: false,
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
