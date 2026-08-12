<?php
/**
 * @var array $rows
 * @var array $filters
 * @var array $counts
 * @var \Mktr\Core\Paginator $paginator
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$heading = 'Halaman';

$statusLabels = ['published' => 'Terbit', 'scheduled' => 'Terjadwal', 'draft' => 'Draf'];
$typeLabels   = ['text' => 'Teks', 'documents' => 'Daftar dokumen', 'grievances' => 'Register pengaduan'];
$sectionLabels = [
    'about' => 'Tentang Kami', 'business' => 'Bisnis Inti', 'sustainability' => 'Keberlanjutan',
    'governance' => 'Tata Kelola', 'investor' => 'Hubungan Investor', 'hr' => 'Sumber Daya Manusia',
];

$urlWith = function (array $overrides) use ($router, $filters) {
    $query = array_filter(array_merge([
        'section' => $filters['section'] !== '' ? $filters['section'] : null,
        'status'  => $filters['status'] !== '' ? $filters['status'] : null,
    ], $overrides));

    return $router->url('admin.pages.index') . ($query === [] ? '' : '?' . http_build_query($query));
};
?>
<div class="a-panel">
  <div class="a-panel__head">
    <div class="a-filters">
      <a class="a-filter<?= $filters['section'] === '' ? ' is-active' : '' ?>"
         href="<?= e($urlWith(['section' => null])) ?>">Semua (<?= (int) $counts['all'] ?>)</a>
      <?php foreach ($sectionLabels as $key => $label): ?>
        <a class="a-filter<?= $filters['section'] === $key ? ' is-active' : '' ?>"
           href="<?= e($urlWith(['section' => $key])) ?>"><?= e($label) ?> (<?= (int) $counts[$key] ?>)</a>
      <?php endforeach; ?>
    </div>
    <a class="a-btn a-btn--sm" href="<?= e($router->url('admin.pages.create')) ?><?= $filters['section'] !== '' ? '?section=' . e($filters['section']) : '' ?>">Tambah halaman</a>
  </div>

  <?php if ($rows === []): ?>
    <div class="a-empty">Tidak ada halaman pada filter ini.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr>
          <th>Judul</th>
          <th style="width:170px">Bagian</th>
          <th style="width:150px">Tipe</th>
          <th style="width:110px">Status</th>
          <th style="width:150px"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td>
              <div class="a-table__title">
                <?php if ($row['parent_id'] !== null): ?><span style="color:var(--ink-300)">└&nbsp;</span><?php endif; ?>
                <?= e($row['title'] !== null ? $row['title'] : '(tanpa judul)') ?>
              </div>
              <div class="a-hint">/<?= e($row['slug']) ?><?= $row['parent_title'] !== null ? ' · di bawah ' . e($row['parent_title']) : '' ?></div>
            </td>
            <td><?= e($sectionLabels[$row['section']] ?? $row['section']) ?></td>
            <td><?= e($typeLabels[$row['type']] ?? $row['type']) ?></td>
            <td><span class="a-pill a-pill--<?= e($row['status']) ?>"><?= e($statusLabels[$row['status']]) ?></span></td>
            <td>
              <div class="a-actions" style="justify-content:flex-end">
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.pages.edit', ['id' => $row['id']])) ?>">Sunting</a>
                <?php if (can('content.delete')): ?>
                  <form method="post" action="<?= e($router->url('admin.pages.destroy', ['id' => $row['id']])) ?>"
                        class="u-inline" data-confirm="Hapus halaman ini? Halaman anak akan naik ke tingkat atas.">
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
        <?php foreach ($paginator->window() as $p): ?>
          <?php if ($p === 0): ?><span class="is-gap">&hellip;</span>
          <?php elseif ($p === $paginator->currentPage()): ?><span class="is-current"><?= (int) $p ?></span>
          <?php else: ?><a href="<?= e($paginator->urlFor($p)) ?>"><?= (int) $p ?></a><?php endif; ?>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>
  <?php endif; ?>
</div>
