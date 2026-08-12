<?php
/**
 * Shared media picker: one modal driving any number of fields on a page.
 *
 * Usage in a form:
 *
 *   <input type="hidden" name="cover_media_id" id="cover_media_id" value="0">
 *   <button type="button"
 *           data-open-media="cover_media_id"   field to write the id into
 *           data-media-kind="image"            'image' | 'document' | ''
 *           data-media-preview="cover-preview" element to update (optional)
 *   >Pilih gambar</button>
 *
 * The preview element is updated by convention: an <img data-preview-image>
 * inside it gets the path, a [data-preview-label] gets the filename, and the
 * container's `hidden` attribute is cleared. A [data-clear-media="<field>"]
 * button resets the pair.
 *
 * @var \Mktr\Core\Router $router
 */
?>
<div class="a-modal" id="media-modal" role="dialog" aria-modal="true" aria-labelledby="media-modal-title">
  <div class="a-modal__backdrop" data-close-media></div>
  <div class="a-modal__panel">
    <div class="a-modal__head">
      <h2 class="a-panel__title" id="media-modal-title">Pustaka Media</h2>
      <div class="a-actions">
        <input class="a-input" type="search" id="media-search" placeholder="Cari berkas…" style="width:200px">
        <label class="a-btn a-btn--ghost a-btn--sm" style="cursor:pointer">
          Unggah
          <input type="file" id="media-upload" hidden>
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

<script>
window.MktrMediaPicker = (function () {
    'use strict';

    var routes = {
        browse: <?= json_encode($router->url('admin.media.browse')) ?>,
        upload: <?= json_encode($router->url('admin.media.store')) ?>
    };
    var csrf = <?= json_encode(csrf_token()) ?>;

    var modal    = document.getElementById('media-modal');
    var grid     = document.getElementById('media-grid');
    var empty    = document.getElementById('media-empty');
    var errorBox = document.getElementById('media-error');
    var search   = document.getElementById('media-search');
    var upload   = document.getElementById('media-upload');

    var kind     = '';     // restricts both browsing and uploading
    var onPick   = null;   // function(item) — set per open
    var timer    = null;

    function showError(message) {
        errorBox.textContent = message || '';
        errorBox.hidden = !message;
    }

    function open(options) {
        kind   = options.kind || '';
        onPick = options.onPick;

        upload.accept = kind === 'document' ? 'application/pdf' : 'image/*';

        modal.classList.add('is-open');
        showError('');
        search.value = '';
        load('');
    }

    function close() {
        modal.classList.remove('is-open');
        onPick = null;
    }

    function load(query) {
        var url = routes.browse + '?q=' + encodeURIComponent(query || '')
                + '&kind=' + encodeURIComponent(kind);

        fetch(url, {
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
            var card = document.createElement('button');
            card.type = 'button';
            card.className = 'a-media';

            if (item.kind === 'document') {
                // PDFs have no thumbnail; show a file card instead of a broken image.
                var badge = document.createElement('div');
                badge.className = 'a-media__file';
                badge.textContent = 'PDF';
                card.appendChild(badge);
            } else {
                var img = document.createElement('img');
                img.src = item.path;
                img.alt = item.alt || item.filename;
                img.loading = 'lazy';
                card.appendChild(img);
            }

            var meta = document.createElement('div');
            meta.className = 'a-media__meta';
            var name = document.createElement('strong');
            name.textContent = item.filename;
            meta.appendChild(name);

            if (item.width && item.height) {
                meta.appendChild(document.createTextNode(item.width + ' × ' + item.height));
            }

            card.appendChild(meta);
            card.addEventListener('click', function () {
                if (typeof onPick === 'function') { onPick(item); }
                close();
            });

            grid.appendChild(card);
        });
    }

    search.addEventListener('input', function () {
        window.clearTimeout(timer);
        timer = window.setTimeout(function () { load(search.value); }, 250);
    });

    upload.addEventListener('change', function (event) {
        var file = event.target.files && event.target.files[0];
        if (!file) { return; }

        var body = new FormData();
        body.append('file', file);
        body.append('_token', csrf);
        body.append('kind', kind === 'document' ? 'document' : 'image');

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

    document.querySelectorAll('[data-close-media]').forEach(function (button) {
        button.addEventListener('click', close);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) { close(); }
    });

    /* ---- declarative field bindings ---------------------------------- */

    function applyToField(fieldId, item) {
        var input = document.getElementById(fieldId);
        if (!input) { return; }

        input.value = item ? item.id : 0;

        var previewId = input.getAttribute('data-preview');
        if (!previewId) { return; }

        var preview = document.getElementById(previewId);
        if (!preview) { return; }

        var image = preview.querySelector('[data-preview-image]');
        var label = preview.querySelector('[data-preview-label]');

        if (item) {
            if (image) { image.src = item.path; }
            if (label) { label.textContent = item.filename; }
            preview.hidden = false;
        } else {
            preview.hidden = true;
        }

        var clear = document.querySelector('[data-clear-media="' + fieldId + '"]');
        if (clear) { clear.hidden = !item; }
    }

    document.querySelectorAll('[data-open-media]').forEach(function (button) {
        button.addEventListener('click', function () {
            var fieldId = button.dataset.openMedia;
            open({
                kind: button.dataset.mediaKind || '',
                onPick: function (item) { applyToField(fieldId, item); }
            });
        });
    });

    document.querySelectorAll('[data-clear-media]').forEach(function (button) {
        button.addEventListener('click', function () {
            applyToField(button.dataset.clearMedia, null);
        });
    });

    // Exposed so the TinyMCE image button can reuse the same library.
    return { open: open, close: close };
})();
</script>
