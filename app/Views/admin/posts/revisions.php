<?php
/**
 * @var array $post
 * @var array $revisions
 * @var \Mktr\Core\Router $router
 */

$layout  = 'layouts.admin';
$heading = 'Riwayat Revisi';
?>
<div class="a-panel">
  <div class="a-panel__head">
    <h2 class="a-panel__title">/<?= e($post['slug']) ?></h2>
    <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.posts.edit', ['id' => $post['id']])) ?>">Kembali ke editor</a>
  </div>

  <?php if ($revisions === []): ?>
    <div class="a-empty">Belum ada revisi tersimpan.</div>
  <?php else: ?>
    <table class="a-table">
      <thead>
        <tr>
          <th style="width:190px">Waktu</th>
          <th>Catatan</th>
          <th style="width:180px">Oleh</th>
          <th style="width:150px"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($revisions as $revision): ?>
          <tr>
            <td><?= e(date('d/m/Y H:i', (int) strtotime((string) $revision['created_at']))) ?></td>
            <td><?= e($revision['note'] !== null ? $revision['note'] : '—') ?></td>
            <td><?= e($revision['author_name'] !== null ? $revision['author_name'] : '—') ?></td>
            <td style="text-align:right">
              <form method="post"
                    action="<?= e($router->url('admin.posts.restore', ['id' => $post['id'], 'revision_id' => $revision['id']])) ?>"
                    data-confirm="Pulihkan versi ini? Kondisi saat ini akan disimpan sebagai revisi baru terlebih dahulu.">
                <?= csrf_field() ?>
                <button class="a-btn a-btn--ghost a-btn--sm" type="submit">Pulihkan</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
