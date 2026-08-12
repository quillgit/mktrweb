<?php
/**
 * Public grievance register (RSPO daftar pengaduan).
 *
 * Shows only what the legacy page published: date, channel, organisation,
 * reporter and case status. Email, phone and address are held in the database
 * but deliberately never queried for this view — see Mktr\Models\Grievance.
 *
 * @var array $page
 * @var array $navItems
 * @var string $activeKey
 * @var array $grievances
 * @var string $section
 */
$layout = 'layouts.front';

$statusLabels = [
    'laporan'    => __('grievance.status.reported'),
    'monitoring' => __('grievance.status.monitoring'),
    'closed'     => __('grievance.status.closed'),
    'dropped'    => __('grievance.status.dropped'),
];
?>
<?= partial('partials.front.page-head', ['page' => $page, 'section' => $section, 'router' => $router]) ?>

<section class="c-section">
  <div class="u-container c-pagelayout">
    <aside class="c-pagelayout__side">
      <?= partial('partials.front.section-nav', [
          'navItems' => $navItems, 'activeKey' => $activeKey, 'section' => $section,
      ]) ?>
    </aside>

    <div class="c-pagelayout__main">
      <?php if (!empty($page['body'])): ?>
        <div class="c-prose" style="margin-bottom:32px"><?= $page['body'] ?></div>
      <?php endif; ?>

      <?php if ($grievances === []): ?>
        <div class="c-empty"><?= e(__('grievance.empty')) ?></div>
      <?php else: ?>
        <div class="c-tablewrap">
          <table class="c-table">
            <thead>
              <tr>
                <th style="width:130px"><?= e(__('grievance.date')) ?></th>
                <th><?= e(__('grievance.channel')) ?></th>
                <th><?= e(__('grievance.organization')) ?></th>
                <th><?= e(__('grievance.reporter')) ?></th>
                <th style="width:140px"><?= e(__('grievance.status')) ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($grievances as $row): ?>
                <tr>
                  <td><?= e($row['reported_on'] !== null ? format_date_id($row['reported_on'], $locale) : '—') ?></td>
                  <td><?= e($row['communication'] !== null ? $row['communication'] : '—') ?></td>
                  <td><?= e($row['organization'] !== null ? $row['organization'] : '—') ?></td>
                  <td><?= e($row['reporter_name'] !== null ? $row['reporter_name'] : '—') ?></td>
                  <td>
                    <span class="c-case c-case--<?= e($row['case_status']) ?>">
                      <?= e(isset($statusLabels[$row['case_status']]) ? $statusLabels[$row['case_status']] : $row['case_status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
