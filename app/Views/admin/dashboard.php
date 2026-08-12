<?php
/**
 * @var array $counts
 * @var array $recent
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$heading = 'Dasbor';

$statusLabels = ['published' => 'Terbit', 'scheduled' => 'Terjadwal', 'draft' => 'Draf'];
?>
<div class="a-grid a-grid--stats" style="margin-bottom:24px">
  <div class="a-stat">
    <div class="a-stat__label">Berita Terbit</div>
    <div class="a-stat__value"><?= (int) $counts['published'] ?></div>
  </div>
  <div class="a-stat">
    <div class="a-stat__label">Terjadwal</div>
    <div class="a-stat__value"><?= (int) $counts['scheduled'] ?></div>
  </div>
  <div class="a-stat">
    <div class="a-stat__label">Draf</div>
    <div class="a-stat__value"><?= (int) $counts['draft'] ?></div>
  </div>
  <div class="a-stat">
    <div class="a-stat__label">Berkas Media</div>
    <div class="a-stat__value"><?= (int) $counts['media'] ?></div>
  </div>
</div>

<div class="a-panel">
  <div class="a-panel__head">
    <h2 class="a-panel__title">Terakhir Disunting</h2>
    <div class="a-actions">
      <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.posts.index')) ?>">Semua berita</a>
      <a class="a-btn a-btn--sm" href="<?= e($router->url('admin.posts.create')) ?>">Tulis berita</a>
    </div>
  </div>

  <?php if ($recent === []): ?>
    <div class="a-empty">Belum ada konten. Mulai dengan menulis berita pertama.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr><th>Judul</th><th>Status</th><th>Publikasi</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($recent as $row): ?>
          <tr>
            <td class="a-table__title"><?= e($row['title'] !== null ? $row['title'] : '(tanpa judul)') ?></td>
            <td><span class="a-pill a-pill--<?= e($row['status']) ?>"><?= e($statusLabels[$row['status']]) ?></span></td>
            <td><?= e($row['published_at'] !== null ? format_date_id($row['published_at'], 'id') : '—') ?></td>
            <td style="text-align:right">
              <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.posts.edit', ['id' => $row['id']])) ?>">Sunting</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
