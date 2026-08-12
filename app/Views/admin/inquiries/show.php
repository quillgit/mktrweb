<?php
/**
 * @var array $inquiry
 * @var array $payload
 * @var array $payloadLabels
 * @var array $kindLabels
 * @var array $statusLabels
 * @var \Mktr\Core\Router $router
 */
$layout  = 'layouts.admin';
$heading = 'Pesan';

$rows = [
    'Jenis'   => isset($kindLabels[$inquiry['kind']]) ? $kindLabels[$inquiry['kind']] : $inquiry['kind'],
    'Nama'    => $inquiry['name'],
    'Email'   => $inquiry['email'],
    'Telepon' => $inquiry['phone'],
    'Perihal' => $inquiry['subject'],
];

foreach ($payload as $key => $value) {
    $label        = isset($payloadLabels[$key]) ? $payloadLabels[$key] : ucfirst(str_replace('_', ' ', (string) $key));
    $rows[$label] = is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
}
?>
<div class="a-grid a-grid--sidebar">
  <div>
    <div class="a-panel">
      <div class="a-panel__head">
        <h2 class="a-panel__title"><?= e($inquiry['subject'] !== null && $inquiry['subject'] !== '' ? $inquiry['subject'] : 'Tanpa perihal') ?></h2>
      </div>
      <div class="a-panel__body">
        <?php if ($inquiry['message'] !== null && trim((string) $inquiry['message']) !== ''): ?>
          <?php /* Plain text from a public form — escaped, never rendered as HTML. */ ?>
          <div class="a-message"><?= nl2br(e($inquiry['message'])) ?></div>
        <?php else: ?>
          <div class="a-empty" style="padding:32px">Tidak ada isi pesan.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div>
    <div class="a-panel">
      <div class="a-panel__head"><h2 class="a-panel__title">Rincian</h2></div>
      <div class="a-panel__body">
        <dl class="a-deflist">
          <?php foreach ($rows as $label => $value): ?>
            <?php if ($value === null || $value === '') { continue; } ?>
            <dt><?= e($label) ?></dt>
            <dd><?= e($value) ?></dd>
          <?php endforeach; ?>
          <dt>Diterima</dt>
          <dd><?= e(format_date_id($inquiry['created_at'], 'id')) ?> <?= e(date('H:i', (int) strtotime((string) $inquiry['created_at']))) ?></dd>
          <dt>Status</dt>
          <dd><?= e($statusLabels[$inquiry['status']]) ?></dd>
          <?php if (!empty($inquiry['ip'])): ?>
            <dt>Alamat IP</dt>
            <dd><?= e($inquiry['ip']) ?></dd>
          <?php endif; ?>
        </dl>
      </div>
      <div class="a-panel__head" style="border-top:1px solid var(--ink-200);border-bottom:0">
        <?php if (!empty($inquiry['email'])): ?>
          <a class="a-btn a-btn--sm" href="mailto:<?= e($inquiry['email']) ?>">Balas lewat email</a>
        <?php endif; ?>
        <a class="a-btn a-btn--ghost a-btn--sm" href="<?= e($router->url('admin.inquiries.index')) ?>">Kembali</a>
      </div>
    </div>
  </div>
</div>
