<?php
/**
 * Post editor: locale tabs, rich text, media picker, publishing workflow.
 *
 * @var array|null $post
 * @var array      $translations locale => row
 * @var array      $media
 * @var array      $formErrors
 * @var string     $previewUrl
 * @var \Mktr\Core\Router $router
 */

$layout   = 'layouts.admin';
$isEdit   = $post !== null;
$heading  = $isEdit ? 'Sunting Berita' : 'Tulis Berita';
$locales  = (array) config('app.locales', ['id']);
$default  = (string) config('app.default_locale', 'id');
$names    = (array) config('app.locale_names', []);

$action = $isEdit
    ? $router->url('admin.posts.update', ['id' => $post['id']])
    : $router->url('admin.posts.store');

/** Prefer submitted-but-rejected input, then stored value. */
$value = function (string $field, string $locale = '') use ($translations, $isEdit) {
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

$status      = old('status', $isEdit ? $post['status'] : 'draft');
$publishedAt = old('published_at', $isEdit && $post['published_at'] !== null
    ? date('Y-m-d\TH:i', (int) strtotime((string) $post['published_at']))
    : '');
$coverId     = (int) old('cover_media_id', $isEdit && $post['cover_media_id'] !== null ? $post['cover_media_id'] : 0);

$coverPath = '';
foreach ($media as $item) {
    if ((int) $item['id'] === $coverId) {
        $coverPath = (string) $item['path'];
    }
}
if ($coverPath === '' && $coverId > 0) {
    $found = (new \Mktr\Models\Media())->find($coverId);
    $coverPath = $found !== null ? (string) $found['path'] : '';
}
?>
<form method="post" action="<?= e($action) ?>" id="post-form">
  <?= csrf_field() ?>
  <input type="hidden" name="cover_media_id" id="cover_media_id" value="<?= $coverId ?>">

  <div class="a-grid a-grid--sidebar">

    <!-- ---- main column ---- -->
    <div>
      <div class="a-panel">
        <div class="a-panel__body">

          <div class="a-tabs" role="tablist">
            <?php foreach ($locales as $i => $code): ?>
              <button class="a-tab<?= $i === 0 ? ' is-active' : '' ?>" type="button"
                      role="tab" data-tab="<?= e($code) ?>"
                      aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
                <?= e(isset($names[$code]) ? $names[$code] : strtoupper($code)) ?>
                <?= $code === $default ? ' *' : '' ?>
              </button>
            <?php endforeach; ?>
          </div>

          <?php foreach ($locales as $i => $code): ?>
            <div class="a-tabpanel" data-panel="<?= e($code) ?>" <?= $i === 0 ? '' : 'hidden' ?>>

              <div class="a-field">
                <label class="a-label" for="title_<?= e($code) ?>">
                  Judul<?= $code === $default ? ' (wajib)' : '' ?>
                </label>
                <input class="a-input<?= isset($formErrors['title_' . $code]) ? ' has-error' : '' ?>"
                       type="text" id="title_<?= e($code) ?>" name="title_<?= e($code) ?>"
                       value="<?= e($value('title', $code)) ?>">
                <?php if (isset($formErrors['title_' . $code])): ?>
                  <p class="a-error"><?= e($formErrors['title_' . $code]) ?></p>
                <?php endif; ?>
              </div>

              <div class="a-field">
                <label class="a-label" for="excerpt_<?= e($code) ?>">Ringkasan</label>
                <textarea class="a-textarea" id="excerpt_<?= e($code) ?>" name="excerpt_<?= e($code) ?>"
                          rows="3"><?= e($value('excerpt', $code)) ?></textarea>
                <p class="a-hint">Dipakai pada kartu berita dan hasil pencarian. Kosongkan untuk mengambil otomatis dari isi.</p>
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

    <!-- ---- sidebar ---- -->
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
            <?php if (isset($formErrors['status'])): ?>
              <p class="a-error"><?= e($formErrors['status']) ?></p>
            <?php endif; ?>
          </div>

          <div class="a-field" id="published-at-field">
            <label class="a-label" for="published_at">Waktu publikasi</label>
            <input class="a-input" type="datetime-local" id="published_at" name="published_at"
                   value="<?= e($publishedAt) ?>">
            <p class="a-hint">Kosongkan saat memilih "Terbit" untuk menayangkan sekarang.</p>
          </div>

          <div class="a-field" style="margin-bottom:0">
            <label class="a-label" for="slug">Slug URL</label>
            <input class="a-input<?= isset($formErrors['slug']) ? ' has-error' : '' ?>"
                   type="text" id="slug" name="slug"
                   value="<?= e(old('slug', $isEdit ? $post['slug'] : '')) ?>"
                   placeholder="dibuat otomatis dari judul">
            <?php if (isset($formErrors['slug'])): ?>
              <p class="a-error"><?= e($formErrors['slug']) ?></p>
            <?php endif; ?>
          </div>

        </div>
        <div class="a-panel__head" style="border-top:1px solid var(--ink-200);border-bottom:0">
          <div class="a-actions">
            <button class="a-btn" type="submit">Simpan</button>
            <?php if ($isEdit && $previewUrl !== ''): ?>
              <a class="a-btn a-btn--gold a-btn--sm" href="<?= e($previewUrl) ?>" target="_blank" rel="noopener">Pratinjau</a>
            <?php endif; ?>
          </div>
          <?php if ($isEdit): ?>
            <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.posts.revisions', ['id' => $post['id']])) ?>">Riwayat</a>
          <?php endif; ?>
        </div>
      </div>

      <div class="a-panel">
        <div class="a-panel__head"><h2 class="a-panel__title">Gambar Sampul</h2></div>
        <div class="a-panel__body">
          <div class="a-cover-preview" id="cover-preview" <?= $coverPath === '' ? 'hidden' : '' ?>>
            <img id="cover-preview-img" src="<?= e($coverPath) ?>" alt="">
          </div>
          <div class="a-actions">
            <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-open-media="cover">Pilih gambar</button>
            <button class="a-btn a-btn--ghost a-btn--sm" type="button" id="cover-clear"
                    <?= $coverPath === '' ? 'hidden' : '' ?>>Hapus</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</form>

<!-- ---- media picker ---- -->
<div class="a-modal" id="media-modal" role="dialog" aria-modal="true" aria-labelledby="media-modal-title">
  <div class="a-modal__backdrop" data-close-media></div>
  <div class="a-modal__panel">
    <div class="a-modal__head">
      <h2 class="a-panel__title" id="media-modal-title">Pustaka Media</h2>
      <div class="a-actions">
        <input class="a-input" type="search" id="media-search" placeholder="Cari berkas…" style="width:200px">
        <label class="a-btn a-btn--ghost a-btn--sm" style="cursor:pointer">
          Unggah
          <input type="file" id="media-upload" accept="image/*" hidden>
        </label>
        <button class="a-btn a-btn--ghost a-btn--sm" type="button" data-close-media>Tutup</button>
      </div>
    </div>
    <div class="a-modal__body">
      <div class="a-notice a-notice--error" id="media-error" hidden></div>
      <div class="a-media-grid" id="media-grid"></div>
      <div class="a-empty" id="media-empty" hidden>Belum ada berkas.</div>
    </div>
  </div>
</div>

<?php ob_start(); ?>
<script src="<?= e(asset('assets/vendor/tinymce/tinymce.min.js')) ?>"></script>
<script>
(function () {
    'use strict';

    var routes = {
        browse: <?= json_encode($router->url('admin.media.browse')) ?>,
        upload: <?= json_encode($router->url('admin.media.store')) ?>
    };
    var csrf = <?= json_encode(csrf_token()) ?>;

    /* ---- locale tabs -------------------------------------------------- */

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

    /* ---- publish-time field visibility -------------------------------- */

    var statusSelect = document.getElementById('status');
    var publishField = document.getElementById('published-at-field');
    var syncStatus = function () {
        // A draft has no go-live time, so the field is meaningless there.
        publishField.hidden = statusSelect.value === 'draft';
    };
    statusSelect.addEventListener('change', syncStatus);
    syncStatus();

    /* ---- media picker -------------------------------------------------- */

    var modal    = document.getElementById('media-modal');
    var grid     = document.getElementById('media-grid');
    var empty    = document.getElementById('media-empty');
    var errorBox = document.getElementById('media-error');
    var search   = document.getElementById('media-search');
    var target   = null;   // 'cover' or a TinyMCE callback
    var timer    = null;

    function showError(message) {
        errorBox.textContent = message;
        errorBox.hidden = !message;
    }

    function openModal(mode) {
        target = mode;
        modal.classList.add('is-open');
        showError('');
        load(search.value);
    }

    function closeModal() {
        modal.classList.remove('is-open');
        target = null;
    }

    document.querySelectorAll('[data-open-media]').forEach(function (button) {
        button.addEventListener('click', function () { openModal(button.dataset.openMedia); });
    });
    document.querySelectorAll('[data-close-media]').forEach(function (button) {
        button.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) { closeModal(); }
    });

    function load(query) {
        fetch(routes.browse + '?q=' + encodeURIComponent(query || ''), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(function (r) { return r.json(); })
        .then(function (data) { render(data.items || []); })
        .catch(function () { showError('Gagal memuat pustaka media.'); });
    }

    function render(items) {
        grid.innerHTML = '';
        empty.hidden = items.length > 0;

        items.forEach(function (item) {
            var figure = document.createElement('button');
            figure.type = 'button';
            figure.className = 'a-media';

            var img = document.createElement('img');
            img.src = item.path;
            img.alt = item.alt || item.filename;
            img.loading = 'lazy';

            var meta = document.createElement('div');
            meta.className = 'a-media__meta';
            var name = document.createElement('strong');
            name.textContent = item.filename;
            meta.appendChild(name);
            if (item.width && item.height) {
                meta.appendChild(document.createTextNode(item.width + ' × ' + item.height));
            }

            figure.appendChild(img);
            figure.appendChild(meta);
            figure.addEventListener('click', function () { choose(item); });
            grid.appendChild(figure);
        });
    }

    function choose(item) {
        if (target === 'cover') {
            document.getElementById('cover_media_id').value = item.id;
            document.getElementById('cover-preview-img').src = item.path;
            document.getElementById('cover-preview').hidden = false;
            document.getElementById('cover-clear').hidden = false;
        } else if (typeof target === 'function') {
            target(item.path, { alt: item.alt || item.filename });
        }
        closeModal();
    }

    search.addEventListener('input', function () {
        window.clearTimeout(timer);
        timer = window.setTimeout(function () { load(search.value); }, 250);
    });

    document.getElementById('media-upload').addEventListener('change', function (event) {
        var file = event.target.files && event.target.files[0];
        if (!file) { return; }

        var body = new FormData();
        body.append('file', file);
        body.append('_token', csrf);

        showError('');

        fetch(routes.upload, {
            method: 'POST',
            body: body,
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
        .then(function (result) {
            if (!result.ok || !result.data.ok) {
                showError(result.data.message || 'Gagal mengunggah berkas.');
                return;
            }
            event.target.value = '';
            load(search.value);
        })
        .catch(function () { showError('Gagal mengunggah berkas.'); });
    });

    document.getElementById('cover-clear').addEventListener('click', function () {
        document.getElementById('cover_media_id').value = 0;
        document.getElementById('cover-preview').hidden = true;
        this.hidden = true;
    });

    /* ---- rich text ----------------------------------------------------- */

    tinymce.init({
        selector: 'textarea.a-richtext',
        license_key: 'gpl',
        base_url: <?= json_encode(asset('assets/vendor/tinymce')) ?>,
        height: 520,
        menubar: false,
        branding: false,
        promotion: false,
        plugins: 'lists link image table code searchreplace fullscreen autolink charmap wordcount',
        toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image table | blockquote removeformat | code fullscreen',
        // Mirrors the server-side allowlist in Mktr\Core\Html so the editor
        // cannot produce markup the sanitiser will silently strip.
        block_formats: 'Paragraf=p; Judul 2=h2; Judul 3=h3; Judul 4=h4',
        valid_elements: 'p[class],br,strong,b,em,i,u,s,sub,sup,'
            + 'h2[id],h3[id],h4[id],h5[id],h6[id],ul,ol[start],li,blockquote[cite],'
            + 'a[href|title|target|rel],img[src|alt|title|width|height|loading],'
            + 'figure[class],figcaption,table[class],thead,tbody,tfoot,tr,'
            + 'th[colspan|rowspan|scope],td[colspan|rowspan],hr,div[class],span[class]',
        content_style: 'body{font-family:Archivo,system-ui,sans-serif;font-size:16px;line-height:1.7;color:#2C3833}',
        convert_urls: false,
        // Route the editor's image button through our own media library rather
        // than letting it upload unmanaged files.
        file_picker_types: 'image',
        file_picker_callback: function (callback) {
            openModal(callback);
        }
    });
})();
</script>
<?php $scripts = ob_get_clean(); ?>
