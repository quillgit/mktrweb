<?php
/**
 * @var array $rows
 * @var array $categories
 * @var int[] $years
 * @var array $filters
 * @var array $counts
 * @var \Mktr\Core\Paginator $paginator
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$heading = 'Dokumen Investor';

$statusLabels = ['published' => 'Terbit', 'scheduled' => 'Terjadwal', 'draft' => 'Draf'];

$urlWith = function (array $overrides) use ($router, $filters) {
    $query = array_filter(array_merge([
        'category' => $filters['category'] > 0 ? $filters['category'] : null,
        'status'   => $filters['status'] !== '' ? $filters['status'] : null,
        'year'     => $filters['year'],
    ], $overrides));

    return $router->url('admin.documents.index') . ($query === [] ? '' : '?' . http_build_query($query));
};
?>
<div class="a-panel">
  <div class="a-panel__head">
    <div class="a-filters">
      <?php
      $statusFilters = [
          ''          => 'Semua (' . (int) $counts['all'] . ')',
          'published' => 'Terbit (' . (int) $counts['published'] . ')',
          'scheduled' => 'Terjadwal (' . (int) $counts['scheduled'] . ')',
          'draft'     => 'Draf (' . (int) $counts['draft'] . ')',
      ];
      foreach ($statusFilters as $key => $label):
      ?>
        <a class="a-filter<?= $filters['status'] === $key ? ' is-active' : '' ?>"
           href="<?= e($urlWith(['status' => $key !== '' ? $key : null])) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </div>
    <a class="a-btn a-btn--sm" href="<?= e($router->url('admin.documents.create')) ?>">Tambah dokumen</a>
  </div>

  <div class="a-panel__body" style="border-bottom:1px solid var(--ink-200);padding-bottom:16px">
    <form method="get" action="<?= e($router->url('admin.documents.index')) ?>" class="a-actions">
      <?php if ($filters['status'] !== ''): ?>
        <input type="hidden" name="status" value="<?= e($filters['status']) ?>">
      <?php endif; ?>

      <label class="a-label u-inline" for="category" style="margin:0">Kategori</label>
      <select class="a-select" name="category" id="category" style="width:250px">
        <option value="">Semua kategori (<?= count($categories) ?>)</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?= (int) $category['id'] ?>" <?= $filters['category'] === (int) $category['id'] ? 'selected' : '' ?>>
            <?= e($category['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="a-label u-inline" for="year" style="margin:0">Tahun</label>
      <select class="a-select" name="year" id="year" style="width:130px">
        <option value="">Semua</option>
        <?php foreach ($years as $year): ?>
          <option value="<?= (int) $year ?>" <?= $filters['year'] === (int) $year ? 'selected' : '' ?>><?= (int) $year ?></option>
        <?php endforeach; ?>
      </select>

      <button class="a-btn a-btn--ghost a-btn--sm" type="submit">Terapkan</button>
      <?php if ($filters['category'] > 0 || $filters['year'] !== null): ?>
        <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.documents.index')) ?>">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <?php if ($rows === []): ?>
    <div class="a-empty">Tidak ada dokumen pada filter ini.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr>
          <th style="width:70px"></th>
          <th>Judul</th>
          <th style="width:190px">Kategori</th>
          <th style="width:120px">Status</th>
          <th style="width:140px">Tanggal</th>
          <th style="width:90px">Unduhan</th>
          <th style="width:170px"></th>
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
              <div class="a-hint">
                <?= empty($row['file_path']) ? '<strong style="color:var(--danger)">berkas belum diunggah</strong>' : e(basename((string) $row['file_path'])) ?>
              </div>
            </td>
            <td><?= e($row['category_name'] !== null ? $row['category_name'] : $row['category_slug']) ?></td>
            <td><span class="a-pill a-pill--<?= e($row['status']) ?>"><?= e($statusLabels[$row['status']]) ?></span></td>
            <td><?= e($row['document_date'] !== null ? format_date_id($row['document_date'], 'id') : '—') ?></td>
            <td><?= (int) $row['downloads'] ?></td>
            <td>
              <div class="a-actions" style="justify-content:flex-end">
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.documents.edit', ['id' => $row['id']])) ?>">Sunting</a>
                <?php if (can('content.delete')): ?>
                  <form method="post"
                        action="<?= e($router->url('admin.documents.destroy', ['id' => $row['id']])) ?>"
                        class="u-inline"
                        data-confirm="Hapus dokumen ini? Berkas PDF tetap tersimpan di pustaka media.">
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
