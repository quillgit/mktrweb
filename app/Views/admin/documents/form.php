<?php
/**
 * Document editor — one form for all 19 categories.
 *
 * @var array|null $document
 * @var array      $translations locale => row
 * @var array      $categories
 * @var array|null $file   media row for the PDF
 * @var array|null $cover  media row for the cover image
 * @var array      $formErrors
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$isEdit  = $document !== null;
$heading = $isEdit ? 'Sunting Dokumen' : 'Tambah Dokumen';
$locales = (array) config('app.locales', ['id']);
$default = (string) config('app.default_locale', 'id');
$names   = (array) config('app.locale_names', []);

$action = $isEdit
    ? $router->url('admin.documents.update', ['id' => $document['id']])
    : $router->url('admin.documents.store');

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

$status       = old('status', $isEdit ? $document['status'] : 'draft');
$categoryId   = (int) old('category_id', $isEdit ? $document['category_id'] : 0);
$sort         = (int) old('sort', $isEdit ? $document['sort'] : 0);
$documentDate = old('document_date', $isEdit && $document['document_date'] !== null ? $document['document_date'] : '');
$publishedAt  = old('published_at', $isEdit && $document['published_at'] !== null
    ? date('Y-m-d\TH:i', (int) strtotime((string) $document['published_at']))
    : '');

$fileId  = (int) old('file_media_id', $isEdit && $document['file_media_id'] !== null ? $document['file_media_id'] : 0);
$coverId = (int) old('cover_media_id', $isEdit && $document['cover_media_id'] !== null ? $document['cover_media_id'] : 0);
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
                <label class="a-label" for="title_<?= e($code) ?>">
                  Judul dokumen<?= $code === $default ? ' (wajib)' : '' ?>
                </label>
                <input class="a-input<?= isset($formErrors['title_' . $code]) ? ' has-error' : '' ?>"
                       type="text" id="title_<?= e($code) ?>" name="title_<?= e($code) ?>"
                       value="<?= e($value('title', $code)) ?>">
                <?php if (isset($formErrors['title_' . $code])): ?>
                  <p class="a-error"><?= e($formErrors['title_' . $code]) ?></p>
                <?php endif; ?>
              </div>

              <div class="a-field" style="margin-bottom:0">
                <label class="a-label" for="description_<?= e($code) ?>">Keterangan</label>
                <textarea class="a-textarea" id="description_<?= e($code) ?>"
                          name="description_<?= e($code) ?>" rows="3"><?= e($value('description', $code)) ?></textarea>
                <p class="a-hint">Baris kecil di bawah judul pada daftar dokumen. Opsional.</p>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>

      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Berkas</h2></div>
        <div class="a-panel__body">

          <div class="a-field">
            <label class="a-label">Berkas PDF</label>
            <input type="hidden" name="file_media_id" id="file_media_id"
                   value="<?= $fileId ?>" data-preview="file-preview">
            <div class="a-file-preview" id="file-preview" <?= $file === null ? 'hidden' : '' ?>>
              <span data-preview-label><?= e($file !== null ? $file['filename'] : '') ?></span>
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-open-media="file_media_id" data-media-kind="document">Pilih / unggah PDF</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-clear-media="file_media_id" <?= $file === null ? 'hidden' : '' ?>>Hapus</button>
            </div>
            <p class="a-hint">Hanya PDF. Tipe berkas diperiksa dari isinya, bukan dari nama berkas.</p>
          </div>

          <div class="a-field" style="margin-bottom:0">
            <label class="a-label">Gambar sampul</label>
            <input type="hidden" name="cover_media_id" id="cover_media_id"
                   value="<?= $coverId ?>" data-preview="cover-preview">
            <div class="a-cover-preview" id="cover-preview" style="max-width:220px"
                 <?= $cover === null ? 'hidden' : '' ?>>
              <img data-preview-image src="<?= e($cover !== null ? $cover['path'] : '') ?>" alt="">
            </div>
            <div class="a-actions">
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-open-media="cover_media_id" data-media-kind="image">Pilih gambar</button>
              <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                      data-clear-media="cover_media_id" <?= $cover === null ? 'hidden' : '' ?>>Hapus</button>
            </div>
            <p class="a-hint">Dipakai kategori bertata letak grid sampul, misalnya Laporan Tahunan.</p>
          </div>

        </div>
      </div>
    </div>

    <div>
      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Publikasi</h2></div>
        <div class="a-panel__body">

          <div class="a-field">
            <label class="a-label" for="category_id">Kategori</label>
            <select class="a-select<?= isset($formErrors['category_id']) ? ' has-error' : '' ?>"
                    id="category_id" name="category_id">
              <option value="">— pilih kategori —</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>>
                  <?= e($category['name']) ?> (<?= e($category['layout'] === 'cover-grid' ? 'grid sampul' : 'daftar') ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($formErrors['category_id'])): ?>
              <p class="a-error"><?= e($formErrors['category_id']) ?></p>
            <?php endif; ?>
          </div>

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
            <input class="a-input" type="datetime-local" id="published_at" name="published_at"
                   value="<?= e($publishedAt) ?>">
            <p class="a-hint">Kosongkan saat memilih "Terbit" untuk menayangkan sekarang.</p>
          </div>

          <div class="a-field">
            <label class="a-label" for="document_date">Tanggal dokumen</label>
            <input class="a-input<?= isset($formErrors['document_date']) ? ' has-error' : '' ?>"
                   type="date" id="document_date" name="document_date" value="<?= e($documentDate) ?>">
            <p class="a-hint">Menentukan tahun pada filter, dan tanggal yang tampil di daftar.</p>
            <?php if (isset($formErrors['document_date'])): ?>
              <p class="a-error"><?= e($formErrors['document_date']) ?></p>
            <?php endif; ?>
          </div>

          <div class="a-field" style="margin-bottom:0">
            <label class="a-label" for="sort">Urutan</label>
            <input class="a-input" type="number" id="sort" name="sort" value="<?= (int) $sort ?>" style="width:110px">
            <p class="a-hint">Angka kecil tampil lebih dulu. Selebihnya diurutkan menurut tanggal.</p>
          </div>

        </div>
        <div class="a-panel__head" style="border-top:1px solid var(--ink-200);border-bottom:0">
          <button class="a-btn" type="submit">Simpan</button>
          <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.documents.index')) ?>">Kembali</a>
        </div>
      </div>
    </div>

  </div>
</form>

<?php ob_start(); ?>
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
    var syncStatus = function () {
        publishField.hidden = statusSelect.value === 'draft';
    };
    statusSelect.addEventListener('change', syncStatus);
    syncStatus();
})();
</script>
<?php $scripts = partial('partials.admin.media-picker') . ob_get_clean(); ?>
