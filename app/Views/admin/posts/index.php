<?php
/**
 * @var array $rows
 * @var \Mktr\Core\Paginator $paginator
 * @var string $status
 * @var array  $counts
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$heading = 'Berita & Kegiatan';

$statusLabels = ['published' => 'Terbit', 'scheduled' => 'Terjadwal', 'draft' => 'Draf'];

$filters = [
    ''          => 'Semua (' . (int) $counts['all'] . ')',
    'published' => 'Terbit (' . (int) $counts['published'] . ')',
    'scheduled' => 'Terjadwal (' . (int) $counts['scheduled'] . ')',
    'draft'     => 'Draf (' . (int) $counts['draft'] . ')',
];
?>
<div class="a-panel">
  <div class="a-panel__head">
    <div class="a-filters">
      <?php foreach ($filters as $key => $label): ?>
        <a class="a-filter<?= $status === $key ? ' is-active' : '' ?>"
           href="<?= e($router->url('admin.posts.index') . ($key !== '' ? '?status=' . $key : '')) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </div>
    <a class="a-btn a-btn--sm" href="<?= e($router->url('admin.posts.create')) ?>">Tulis berita</a>
  </div>

  <?php if ($rows === []): ?>
    <div class="a-empty">Tidak ada berita pada filter ini.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr>
          <th style="width:84px"></th>
          <th>Judul</th>
          <th style="width:120px">Status</th>
          <th style="width:170px">Publikasi</th>
          <th style="width:90px">Dilihat</th>
          <th style="width:220px"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td>
              <?php if (!empty($row['cover_path'])): ?>
                <img class="a-table__thumb" src="<?= e($row['cover_path']) ?>" alt="" loading="lazy">
              <?php else: ?>
                <div class="a-table__thumb"></div>
              <?php endif; ?>
            </td>
            <td>
              <div class="a-table__title"><?= e($row['title'] !== null ? $row['title'] : '(tanpa judul)') ?></div>
              <div class="a-hint">/<?= e($row['slug']) ?><?= $row['author_name'] !== null ? ' · ' . e($row['author_name']) : '' ?></div>
            </td>
            <td><span class="a-pill a-pill--<?= e($row['status']) ?>"><?= e($statusLabels[$row['status']]) ?></span></td>
            <td><?= e($row['published_at'] !== null ? format_date_id($row['published_at'], 'id') : '—') ?></td>
            <td><?= (int) $row['views'] ?></td>
            <td>
              <div class="a-actions" style="justify-content:flex-end">
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.posts.revisions', ['id' => $row['id']])) ?>">Riwayat</a>
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.posts.edit', ['id' => $row['id']])) ?>">Sunting</a>
                <?php if (can('content.delete')): ?>
                  <form method="post"
                        action="<?= e($router->url('admin.posts.destroy', ['id' => $row['id']])) ?>"
                        class="u-inline"
                        data-confirm="Hapus berita ini? Tindakan ini tidak dapat dibatalkan.">
                    <?= csrf_field() ?>
                    <button class="a-btn a-btn--danger a-btn--sm" type="submit">Hapus</button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

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
  <?php endif; ?>
</div>
