<?php
/**
 * @var array  $items
 * @var \Mktr\Core\Paginator $paginator
 * @var string $search
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$heading = 'Pustaka Media';
?>
<div class="a-panel">
  <div class="a-panel__head">
    <form method="get" action="<?= e($router->url('admin.media.index')) ?>" class="a-actions">
      <input class="a-input" type="search" name="q" value="<?= e($search) ?>" placeholder="Cari berkas…" style="width:240px">
      <button class="a-btn a-btn--ghost a-btn--sm" type="submit">Cari</button>
      <?php if ($search !== ''): ?>
        <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.media.index')) ?>">Reset</a>
      <?php endif; ?>
    </form>

    <?php if (can('media.upload')): ?>
      <form method="post" action="<?= e($router->url('admin.media.store')) ?>"
            enctype="multipart/form-data" class="a-actions" id="upload-form">
        <?= csrf_field() ?>
        <input class="a-input" type="file" name="file" accept="image/*" required style="width:230px">
        <button class="a-btn a-btn--sm" type="submit">Unggah</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="a-panel__body">
    <?php if ($items === []): ?>
      <div class="a-empty">Tidak ada berkas<?= $search !== '' ? ' yang cocok dengan pencarian.' : '.' ?></div>
    <?php else: ?>
      <div class="a-media-grid">
        <?php foreach ($items as $item): ?>
          <figure class="a-media" style="cursor:default;margin:0">
            <img src="<?= e($item['path']) ?>" alt="<?= e($item['alt'] !== null ? $item['alt'] : $item['filename']) ?>" loading="lazy">
            <figcaption class="a-media__meta">
              <strong title="<?= e($item['filename']) ?>"><?= e($item['filename']) ?></strong>
              <?php if ($item['width'] !== null): ?>
                <?= (int) $item['width'] ?> × <?= (int) $item['height'] ?> ·
              <?php endif; ?>
              <?= e(format_bytes((int) $item['size'])) ?>
              <?php if (can('media.delete')): ?>
                <form method="post"
                      action="<?= e($router->url('admin.media.destroy', ['id' => $item['id']])) ?>"
                      data-confirm="Hapus berkas ini dari pustaka?"
                      style="margin-top:6px">
                  <?= csrf_field() ?>
                  <button class="a-btn a-btn--danger a-btn--sm" type="submit" style="width:100%">Hapus</button>
                </form>
              <?php endif; ?>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($paginator->hasPages()): ?>
    <nav class="a-pagination" aria-label="Halaman">
      <?php foreach ($paginator->window() as $page): ?>
        <?php if ($page === 0): ?>
          <span class="is-gap">&hellip;</span>
        <?php elseif ($page === $paginator->currentPage()): ?>
          <span class="is-current"><?= (int) $page ?></span>
        <?php else: ?>
          <a href="<?= e($paginator->urlFor($page)) ?>"><?= (int) $page ?></a>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
  <?php endif; ?>
</div>
