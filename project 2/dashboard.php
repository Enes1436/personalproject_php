<?php
$page = 'Dashboard';
require_once __DIR__ . '/header.php';
require_admin();

$cars_count    = $pdo->query("SELECT COUNT(*) FROM cars")->fetchColumn();
$bookings_count= $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pending_count = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status='pending'")->fetchColumn();
$revenue       = $pdo->query("SELECT COALESCE(SUM(total_price),0) FROM bookings WHERE status IN ('confirmed','completed')")->fetchColumn();

$recent = $pdo->query("SELECT b.*, c.brand, c.model FROM bookings b JOIN cars c ON c.id=b.car_id ORDER BY b.created_at DESC LIMIT 5")->fetchAll();
?>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="admin-content">
    <h2 class="fw-bold mb-1">Dashboard</h2>
    <p class="text-secondary">Welcome back, <?= e($_SESSION['user']['name']) ?>.</p>

    <div class="row g-3 mt-2">
      <?php
      $stats = [
        ['Cars',$cars_count,'bi-car-front','#ffb703'],
        ['Bookings',$bookings_count,'bi-calendar-check','#38bdf8'],
        ['Pending',$pending_count,'bi-hourglass-split','#f97316'],
        ['Revenue','$'.number_format($revenue,2),'bi-cash-coin','#22c55e'],
      ];
      foreach ($stats as $s): ?>
        <div class="col-sm-6 col-lg-3">
          <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
              <div class="lbl"><?= e($s[0]) ?></div>
              <div class="num"><?= e($s[1]) ?></div>
            </div>
            <div class="ico" style="background:<?= $s[3] ?>22;color:<?= $s[3] ?>"><i class="bi <?= $s[2] ?>"></i></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Recent Bookings</h4>
        <a href="bookings.php" class="btn btn-ghost btn-sm">View all</a>
      </div>
      <div class="table-dark-app">
        <table class="table align-middle">
          <thead><tr><th>Car</th><th>Customer</th><th>Dates</th><th>Total</th><th>Status</th></tr></thead>
          <tbody>
            <?php if (!$recent): ?>
              <tr><td colspan="5" class="text-center text-secondary py-4">No bookings yet.</td></tr>
            <?php endif; ?>
            <?php foreach ($recent as $b): ?>
              <tr>
                <td class="fw-semibold"><?= e($b['brand'].' '.$b['model']) ?></td>
                <td><?= e($b['full_name']) ?><br><small class="text-secondary"><?= e($b['email']) ?></small></td>
                <td><?= e($b['pickup_date']) ?> → <?= e($b['return_date']) ?></td>
                <td class="fw-bold text-warning">$<?= number_format($b['total_price'],2) ?></td>
                <td><span class="badge bg-secondary"><?= e($b['status']) ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>