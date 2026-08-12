<?php
/**
 * One form for every site setting, grouped.
 *
 * @var array $rows
 * @var array $translations  setting id => locale => value
 * @var array $groupLabels
 * @var array $keyLabels
 * @var array $richText
 * @var array $withMedia
 * @var array $untranslated
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$heading = 'Pengaturan Situs';
$locales = (array) config('app.locales', ['id']);
$names   = (array) config('app.locale_names', []);

$grouped = [];
foreach ($rows as $row) {
    $grouped[(string) $row['group']][] = $row;
}

$label = function (string $key) use ($keyLabels) {
    return isset($keyLabels[$key]) ? $keyLabels[$key] : $key;
};
?>
<form method="post" action="<?= e($router->url('admin.settings.update')) ?>">
  <?= csrf_field() ?>

  <?php foreach ($grouped as $group => $items): ?>
    <div class="a-panel">
      <div class="a-panel__head">
        <h2 class="a-panel__title"><?= e(isset($groupLabels[$group]) ? $groupLabels[$group] : $group) ?></h2>
      </div>
      <div class="a-panel__body">
        <?php foreach ($items as $row): ?>
          <?php
          $id    = (int) $row['id'];
          $key   = (string) $row['key'];
          $rich  = in_array($key, $richText, true);
          $plain = in_array($key, $untranslated, true);
          $slots = isset($withMedia[$key]) ? (int) $withMedia[$key] : 0;
          ?>
          <div class="a-field">
            <label class="a-label" for="setting-<?= $id ?>"><?= e($label($key)) ?></label>

            <?php if ($plain): ?>
              <input class="a-input" type="text" id="setting-<?= $id ?>" name="value_<?= $id ?>"
                     value="<?= e($row['value'] !== null ? $row['value'] : '') ?>">
              <p class="a-hint">Sama untuk semua bahasa.</p>

            <?php else: ?>
              <?php foreach ($locales as $code): ?>
                <?php $value = isset($translations[$id][$code]) ? (string) $translations[$id][$code] : ''; ?>
                <div style="margin-bottom:10px">
                  <span class="a-hint"><?= e(isset($names[$code]) ? $names[$code] : strtoupper($code)) ?></span>
                  <?php if ($rich): ?>
                    <textarea class="a-richtext" id="setting-<?= $id ?>-<?= e($code) ?>"
                              name="value_<?= $id ?>_<?= e($code) ?>"><?= e($value) ?></textarea>
                  <?php else: ?>
                    <input class="a-input" type="text" id="setting-<?= $id ?>-<?= e($code) ?>"
                           name="value_<?= $id ?>_<?= e($code) ?>" value="<?= e($value) ?>">
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>

            <?php for ($slot = 1; $slot <= $slots; $slot++): ?>
              <?php
              $inputName = $slot === 1 ? 'media_' . $id : 'media_2_' . $id;
              $current   = $slot === 1 ? $row['media'] : $row['media_2'];
              $currentId = $slot === 1 ? $row['media_id'] : $row['media_2_id'];
              ?>
              <div style="margin-top:12px">
                <span class="a-hint">Gambar <?= $slot ?></span>
                <input type="hidden" name="<?= e($inputName) ?>" id="<?= e($inputName) ?>"
                       value="<?= (int) ($currentId !== null ? $currentId : 0) ?>"
                       data-preview="preview-<?= e($inputName) ?>">
                <div class="a-cover-preview" id="preview-<?= e($inputName) ?>" <?= $current === null ? 'hidden' : '' ?>>
                  <img data-preview-image src="<?= e($current !== null ? $current['path'] : '') ?>" alt="">
                </div>
                <div class="a-actions">
                  <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                          data-open-media="<?= e($inputName) ?>" data-media-kind="image">Pilih</button>
                  <button class="a-btn a-btn--ghost a-btn--sm" type="button"
                          data-clear-media="<?= e($inputName) ?>" <?= $current === null ? 'hidden' : '' ?>>Hapus</button>
                </div>
              </div>
            <?php endfor; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="a-panel">
    <div class="a-panel__head" style="border-bottom:0">
      <button class="a-btn" type="submit">Simpan pengaturan</button>
    </div>
  </div>
</form>

<?php ob_start(); ?>
<script src="<?= e(asset('assets/vendor/tinymce/tinymce.min.js')) ?>"></script>
<script>
tinymce.init({
    selector: 'textarea.a-richtext',
    license_key: 'gpl',
    base_url: <?= json_encode(asset('assets/vendor/tinymce')) ?>,
    height: 320, menubar: false, branding: false, promotion: false,
    plugins: 'lists link image table code searchreplace fullscreen autolink charmap wordcount',
    toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image | blockquote removeformat | code fullscreen',
    block_formats: 'Paragraf=p; Judul 2=h2; Judul 3=h3',
    content_style: 'body{font-family:Archivo,system-ui,sans-serif;font-size:16px;line-height:1.7;color:#2C3833}',
    convert_urls: false,
    file_picker_types: 'image',
    file_picker_callback: function (callback) {
        window.MktrMediaPicker.open({ kind: 'image', onPick: function (item) { callback(item.path, { alt: item.alt || item.filename }); } });
    }
});
</script>
<?php $scripts = partial('partials.admin.media-picker') . ob_get_clean(); ?>
