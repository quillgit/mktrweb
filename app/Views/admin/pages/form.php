<?php
/**
 * Content page editor — one form for all six sections.
 *
 * @var array|null $page
 * @var array      $translations
 * @var array      $categories
 * @var array      $parents
 * @var string     $section
 * @var array|null $banner
 * @var array|null $cover
 * @var array      $formErrors
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$isEdit  = $page !== null;
$heading = $isEdit ? 'Sunting Halaman' : 'Tambah Halaman';
$locales = (array) config('app.locales', ['id']);
$default = (string) config('app.default_locale', 'id');
$names   = (array) config('app.locale_names', []);

$sectionLabels = [
    'about' => 'Tentang Kami', 'business' => 'Bisnis Inti', 'sustainability' => 'Keberlanjutan',
    'governance' => 'Tata Kelola', 'investor' => 'Hubungan Investor', 'hr' => 'Sumber Daya Manusia',
];

$action = $isEdit
    ? $router->url('admin.pages.update', ['id' => $page['id']])
    : $router->url('admin.pages.store');

$value = function (string $field, string $locale = '') use ($translations) {
    $key = $locale === '' ? $field : $field . '_' . $locale;
    $old = old($key, null);

    if ($old !== null) {
        return (string) $old;
    }

    if ($locale !== '' && isset($translations[$locale][$field])) {
        return (string) $translations[$locale][$field];
    }

    return '';
};

$type        = old('type', $isEdit ? $page['type'] : 'text');
$status      = old('status', $isEdit ? $page['status'] : 'draft');
$parentId    = (int) old('parent_id', $isEdit && $page['parent_id'] !== null ? $page['parent_id'] : 0);
$categoryId  = (int) old('document_category_id', $isEdit && $page['document_category_id'] !== null ? $page['document_category_id'] : 0);
$sort        = (int) old('sort', $isEdit ? $page['sort'] : 0);
$publishedAt = old('published_at', $isEdit && $page['published_at'] !== null
    ? date('Y-m-d\TH:i', (int) strtotime((string) $page['published_at']))
    : '');
$bannerId = (int) old('banner_media_id', $isEdit && $page['banner_media_id'] !== null ? $page['banner_media_id'] : 0);
$coverId  = (int) old('cover_media_id', $isEdit && $page['cover_media_id'] !== null ? $page['cover_media_id'] : 0);
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
                <input class="a-input<?= isset($formErrors['title_' . $code]) ? ' has-error' : '' ?>"
                       type="text" id="title_<?= e($code) ?>" name="title_<?= e($code) ?>"
                       value="<?= e($value('title', $code)) ?>">
                <?php if (isset($formErrors['title_' . $code])): ?>
                  <p class="a-error"><?= e($formErrors['title_' . $code]) ?></p>
                <?php endif; ?>
              </div>

              <div class="a-field">
                <label class="a-label" for="slug_<?= e($code) ?>">Slug URL (<?= e(strtoupper($code)) ?>)</label>
                <input class="a-input<?= isset($formErrors['slug_' . $code]) ? ' has-error' : '' ?>"
                       type="text" id="slug_<?= e($code) ?>" name="slug_<?= e($code) ?>"
                       value="<?= e($value('slug', $code)) ?>" placeholder="dibuat otomatis dari judul">
                <p class="a-hint">Situs lama menyimpan slug terpisah per bahasa; keduanya tetap dapat diakses.</p>
                <?php if (isset($formErrors['slug_' . $code])): ?>
                  <p class="a-error"><?= e($formErrors['slug_' . $code]) ?></p>
                <?php endif; ?>
              </div>

              <div class="a-field">
                <label class="a-label" for="subtitle_<?= e($code) ?>">Sub judul</label>
                <input class="a-input" type="text" id="subtitle_<?= e($code) ?>"
                       name="subtitle_<?= e($code) ?>" value="<?= e($value('subtitle', $code)) ?>">
              </div>

              <div class="a-field">
                <label class="a-label" for="body_<?= e($code) ?>">Isi</label>
                <textarea class="a-richtext" id="body_<?= e($code) ?>" name="body_<?= e($code) ?>"><?= e($value('body', $code)) ?></textarea>
              </div>

              <details style="margin-top:8px">
                <summary style="cursor:pointer;font-weight:600;font-size:13.5px;color:var(--ink-600)">Pengaturan SEO</summary>
                <div style="padding-top:14px">
                  <div class="a-field">
                    <label class="a-label" for="meta_title_<?= e($code) ?>">Meta title</label>
                    <input class="a-input" type="text" id="meta_title_<?= e($code) ?>"
                           name="meta_title_<?= e($code) ?>" value="<?= e($value('meta_title', $code)) ?>">
                  </div>
                  <div class="a-field" style="margin-bottom:0">
                    <label class="a-label" for="meta_description_<?= e($code) ?>">Meta description</label>
                    <textarea class="a-textarea" id="meta_description_<?= e($code) ?>"
                              name="meta_description_<?= e($code) ?>" rows="2"><?= e($value('meta_description', $code)) ?></textarea>
                  </div>
                </div>
              </details>
            </div>
          <?php endforeach; ?>

        </div>
      </div>
    </div>

    <div>
      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Penempatan</h2></div>
        <div class="a-panel__body">

          <div class="a-field">
            <label class="a-label" for="section">Bagian</label>
            <select class="a-select" id="section" name="section">
              <?php foreach ($sectionLabels as $key => $label): ?>
                <option value="<?= e($key) ?>" <?= $section === $key ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
            <p class="a-hint">Menentukan URL: bisnis, keberlanjutan, tatakelola_perusahaan, hubungan_investor, sdm.</p>
          </div>

          <div class="a-field">
            <label class="a-label" for="parent_id">Induk</label>
            <select class="a-select" id="parent_id" name="parent_id">
              <option value="0">— tingkat atas —</option>
              <?php foreach ($parents as $parent): ?>
                <option value="<?= (int) $parent['id'] ?>" <?= $parentId === (int) $parent['id'] ? 'selected' : '' ?>>
                  <?= e($parent['title']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="a-field">
            <label class="a-label" for="type">Tipe halaman</label>
            <select class="a-select" id="type" name="type">
              <option value="text" <?= $type === 'text' ? 'selected' : '' ?>>Teks</option>
              <option value="documents" <?= $type === 'documents' ? 'selected' : '' ?>>Daftar dokumen</option>
              <option value="grievances" <?= $type === 'grievances' ? 'selected' : '' ?>>Register pengaduan</option>
            </select>
          </div>

          <div class="a-field" id="category-field">
            <label class="a-label" for="document_category_id">Kategori dokumen</label>
            <select class="a-select" id="document_category_id" name="document_category_id">
              <option value="0">— pilih kategori —</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>>
                  <?= e($category['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <p class="a-hint">Daftar dokumen yang ditampilkan pada halaman ini.</p>
          </div>

          <div class="a-field" style="margin-bottom:0">
            <label class="a-label" for="sort">Urutan</label>
            <input class="a-input" type="number" id="sort" name="sort" value="<?= (int) $sort ?>" style="width:110px">
          </div>

        </div>
      </div>

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

          <div class="a-field" id="published-at-field" style="margin-bottom:0">
            <label class="a-label" for="published_at">Waktu publikasi</label>
            <input class="a-input" type="datetime-local" id="published_at" name="published_at" value="<?= e($publishedAt) ?>">
          </div>
        </div>
        <div class="a-panel__head" style="border-top:1px solid var(--ink-200);border-bottom:0">
          <button class="a-btn" type="submit">Simpan</button>
          <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.pages.index')) ?>">Kembali</a>
        </div>
      </div>

      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Gambar</h2></div>
        <div class="a-panel__body">
          <div class="a-field">
            <label class="a-label">Banner halaman</label>
            <input type="hidden" name="banner_media_id" id="banner_media_id" value="<?= $bannerId ?>" data-preview="banner-preview">
            <div class="a-cover-preview" id="banner-preview" <?= $banner === null ? 'hidden' : '' ?>>
              <img data-preview-image src="<?= e($banner !== null ? $banner['path'] : '') ?>" alt="">
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-open-media="banner_media_id" data-media-kind="image">Pilih</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-clear-media="banner_media_id" <?= $banner === null ? 'hidden' : '' ?>>Hapus</button>
            </div>
          </div>

          <div class="a-field" style="margin-bottom:0">
            <label class="a-label">Gambar isi</label>
            <input type="hidden" name="cover_media_id" id="cover_media_id" value="<?= $coverId ?>" data-preview="cover-preview">
            <div class="a-cover-preview" id="cover-preview" <?= $cover === null ? 'hidden' : '' ?>>
              <img data-preview-image src="<?= e($cover !== null ? $cover['path'] : '') ?>" alt="">
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-open-media="cover_media_id" data-media-kind="image">Pilih</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-clear-media="cover_media_id" <?= $cover === null ? 'hidden' : '' ?>>Hapus</button>
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
            document.querySelectorAll('.a-tabpanel').forEach(function (panel) {
                panel.hidden = panel.dataset.panel !== code;
            });
        });
    });

    var statusSelect = document.getElementById('status');
    var publishField = document.getElementById('published-at-field');
    var syncStatus = function () { publishField.hidden = statusSelect.value === 'draft'; };
    statusSelect.addEventListener('change', syncStatus);
    syncStatus();

    // The document-category selector only means anything for a documents page.
    var typeSelect    = document.getElementById('type');
    var categoryField = document.getElementById('category-field');
    var syncType = function () { categoryField.hidden = typeSelect.value !== 'documents'; };
    typeSelect.addEventListener('change', syncType);
    syncType();

    tinymce.init({
        selector: 'textarea.a-richtext',
        license_key: 'gpl',
        base_url: <?= json_encode(asset('assets/vendor/tinymce')) ?>,
        height: 460,
        menubar: false,
        branding: false,
        promotion: false,
        plugins: 'lists link image table code searchreplace fullscreen autolink charmap wordcount',
        toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image table | blockquote removeformat | code fullscreen',
        block_formats: 'Paragraf=p; Judul 2=h2; Judul 3=h3; Judul 4=h4',
        valid_elements: 'p[class],br,strong,b,em,i,u,s,sub,sup,'
            + 'h2[id],h3[id],h4[id],h5[id],h6[id],ul,ol[start],li,blockquote[cite],'
            + 'a[href|title|target|rel],img[src|alt|title|width|height|loading],'
            + 'figure[class],figcaption,table[class],thead,tbody,tfoot,tr,'
            + 'th[colspan|rowspan|scope],td[colspan|rowspan],hr,div[class],span[class]',
        content_style: 'body{font-family:Archivo,system-ui,sans-serif;font-size:16px;line-height:1.7;color:#2C3833}',
        convert_urls: false,
        file_picker_types: 'image',
        file_picker_callback: function (callback) {
            window.MktrMediaPicker.open({
                kind: 'image',
                onPick: function (item) { callback(item.path, { alt: item.alt || item.filename }); }
            });
        }
    });
})();
</script>
<?php $scripts = partial('partials.admin.media-picker') . ob_get_clean(); ?>
