<?php
/**
 * @var array $rows
 * @var \Mktr\Core\Paginator $paginator
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$heading = 'Karir';
$statusLabels = ['published' => 'Terbit', 'scheduled' => 'Terjadwal', 'draft' => 'Draf'];
?>
<div class="a-panel">
  <div class="a-panel__head">
    <h2 class="a-panel__title">Lowongan</h2>
    <a class="a-btn a-btn--sm" href="<?= e($router->url('admin.careers.create')) ?>">Tambah lowongan</a>
  </div>

  <?php if ($rows === []): ?>
    <div class="a-empty">Belum ada lowongan.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr><th>Judul</th><th style="width:170px">Lokasi</th><th style="width:150px">Ditutup</th><th style="width:110px">Status</th><th style="width:150px"></th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td>
              <div class="a-table__title"><?= e($row['title'] !== null ? $row['title'] : '(tanpa judul)') ?></div>
              <div class="a-hint">/<?= e($row['slug']) ?></div>
            </td>
            <td><?= e($row['location'] !== null ? $row['location'] : '—') ?></td>
            <td><?= e($row['closes_on'] !== null ? format_date_id($row['closes_on'], 'id') : '—') ?></td>
            <td><span class="a-pill a-pill--<?= e($row['status']) ?>"><?= e($statusLabels[$row['status']]) ?></span></td>
            <td>
              <div class="a-actions" style="justify-content:flex-end">
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.careers.edit', ['id' => $row['id']])) ?>">Sunting</a>
                <?php if (can('content.delete')): ?>
                  <form method="post" action="<?= e($router->url('admin.careers.destroy', ['id' => $row['id']])) ?>"
                        class="u-inline" data-confirm="Hapus lowongan ini?">
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
  <?php endif; ?>
</div>
