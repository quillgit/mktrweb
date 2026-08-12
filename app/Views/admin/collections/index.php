<?php
/**
 * @var array  $rows
 * @var string $kind
 * @var array  $labels
 * @var array  $groups
 * @var \Mktr\Core\Paginator $paginator
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$heading = 'Koleksi';

$base = $router->url('admin.collections.index');
?>
<div class="a-panel">
  <div class="a-panel__head">
    <h2 class="a-panel__title"><?= e($kind !== '' ? $labels[$kind][1] : 'Semua koleksi') ?></h2>
    <a class="a-btn a-btn--sm"
       href="<?= e($router->url('admin.collections.create') . ($kind !== '' ? '?kind=' . $kind : '')) ?>">Tambah</a>
  </div>

  <div class="a-panel__body" style="padding-bottom:0">
    <div class="a-filters">
      <a class="a-filter<?= $kind === '' ? ' is-active' : '' ?>" href="<?= e($base) ?>">Semua</a>
      <?php foreach ($labels as $key => $label): ?>
        <a class="a-filter<?= $kind === $key ? ' is-active' : '' ?>"
           href="<?= e($base . '?kind=' . $key) ?>"><?= e($label[1]) ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if ($rows === []): ?>
    <div class="a-empty">Belum ada data.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr>
          <th style="width:64px"></th>
          <th>Judul</th>
          <th style="width:150px">Jenis</th>
          <th style="width:130px">Kelompok</th>
          <th style="width:60px">Urut</th>
          <th style="width:100px">Status</th>
          <th style="width:180px"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td>
              <?php if (!empty($row['image_path'])): ?>
                <img class="a-thumb" src="<?= e($row['image_path']) ?>" alt="" loading="lazy">
              <?php endif; ?>
            </td>
            <td>
              <div class="a-table__title"><?= e($row['title'] !== null ? $row['title'] : '(tanpa judul)') ?></div>
              <?php if (!empty($row['slug'])): ?><div class="a-hint"><?= e($row['slug']) ?></div><?php endif; ?>
            </td>
            <td><?= e(isset($labels[$row['kind']]) ? $labels[$row['kind']][1] : $row['kind']) ?></td>
            <td><?= e($row['group_key'] !== null && isset($groups[$row['group_key']]) ? $groups[$row['group_key']] : '—') ?></td>
            <td><?= (int) $row['sort'] ?></td>
            <td><span class="a-pill a-pill--<?= e($row['status']) ?>"><?= $row['status'] === 'published' ? 'Terbit' : 'Draf' ?></span></td>
            <td>
              <div class="a-actions" style="justify-content:flex-end">
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.collections.edit', ['id' => $row['id']])) ?>">Sunting</a>
                <?php if (can('content.delete')): ?>
                  <form method="post" action="<?= e($router->url('admin.collections.destroy', ['id' => $row['id']])) ?>"
                        class="u-inline" data-confirm="Hapus data ini?">
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
