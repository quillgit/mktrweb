<?php
/**
 * @var array  $rows
 * @var string $kind
 * @var string $status
 * @var array  $kindLabels
 * @var array  $statusLabels
 * @var int    $unread
 * @var \Mktr\Core\Paginator $paginator
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$heading = 'Formulir & Pesan';

$base = $router->url('admin.inquiries.index');
$link = function (string $k, string $s) use ($base) {
    $q = [];
    if ($k !== '') { $q[] = 'kind=' . $k; }
    if ($s !== '') { $q[] = 'status=' . $s; }

    return $base . ($q === [] ? '' : '?' . implode('&', $q));
};
?>
<div class="a-panel">
  <div class="a-panel__head">
    <h2 class="a-panel__title">Kotak masuk</h2>
    <?php if ($unread > 0): ?>
      <span class="a-pill a-pill--scheduled"><?= (int) $unread ?> belum dibaca</span>
    <?php endif; ?>
  </div>

  <div class="a-panel__body" style="padding-bottom:0">
    <div class="a-filters" style="margin-bottom:10px">
      <a class="a-filter<?= $kind === '' ? ' is-active' : '' ?>" href="<?= e($link('', $status)) ?>">Semua jenis</a>
      <?php foreach ($kindLabels as $key => $label): ?>
        <a class="a-filter<?= $kind === $key ? ' is-active' : '' ?>" href="<?= e($link($key, $status)) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </div>
    <div class="a-filters">
      <a class="a-filter<?= $status === '' ? ' is-active' : '' ?>" href="<?= e($link($kind, '')) ?>">Semua status</a>
      <?php foreach ($statusLabels as $key => $label): ?>
        <a class="a-filter<?= $status === $key ? ' is-active' : '' ?>" href="<?= e($link($kind, $key)) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if ($rows === []): ?>
    <div class="a-empty">Belum ada pesan.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr>
          <th style="width:170px">Jenis</th>
          <th>Pengirim</th>
          <th>Perihal</th>
          <th style="width:150px">Diterima</th>
          <th style="width:110px">Status</th>
          <th style="width:150px"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= e(isset($kindLabels[$row['kind']]) ? $kindLabels[$row['kind']] : $row['kind']) ?></td>
            <td>
              <div class="a-table__title"><?= e($row['name'] !== null && $row['name'] !== '' ? $row['name'] : '(tanpa nama)') ?></div>
              <?php if (!empty($row['email'])): ?><div class="a-hint"><?= e($row['email']) ?></div><?php endif; ?>
            </td>
            <td><?= e($row['subject'] !== null && $row['subject'] !== '' ? $row['subject'] : '—') ?></td>
            <td><?= e(format_date_id($row['created_at'], 'id')) ?></td>
            <td><span class="a-pill a-pill--<?= $row['status'] === 'new' ? 'scheduled' : 'draft' ?>"><?= e($statusLabels[$row['status']]) ?></span></td>
            <td>
              <div class="a-actions" style="justify-content:flex-end">
                <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.inquiries.show', ['id' => $row['id']])) ?>">Baca</a>
                <?php if (can('content.delete')): ?>
                  <form method="post" action="<?= e($router->url('admin.inquiries.destroy', ['id' => $row['id']])) ?>"
                        class="u-inline" data-confirm="Hapus pesan ini?">
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
