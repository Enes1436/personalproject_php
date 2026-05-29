<?php
require __DIR__.'/auth.php';
$cars = $pdo->query("SELECT COUNT(*) FROM cars")->fetchColumn();
$bookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status='Ne pritje'")->fetchColumn();
$revenue = $pdo->query("SELECT COALESCE(SUM(total_price),0) FROM bookings WHERE status='Konfirmuar'")->fetchColumn();
$pageTitle='Dashboard'; $active='dash';
include '_layout.php';
?>
<h1>Dashboard</h1>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-top:20px">
  <div style="background:#fff;padding:20px;border-radius:10px"><div style="color:#64748b">Makina</div><div style="font-size:2rem;font-weight:700"><?= $cars ?></div></div>
  <div style="background:#fff;padding:20px;border-radius:10px"><div style="color:#64748b">Rezervime</div><div style="font-size:2rem;font-weight:700"><?= $bookings ?></div></div>
  <div style="background:#fff;padding:20px;border-radius:10px"><div style="color:#64748b">Në pritje</div><div style="font-size:2rem;font-weight:700;color:#f59e0b"><?= $pending ?></div></div>
  <div style="background:#fff;padding:20px;border-radius:10px"><div style="color:#64748b">Të ardhura</div><div style="font-size:2rem;font-weight:700;color:#10b981">€<?= number_format($revenue,0) ?></div></div>
</div>
<?php include '_layout_end.php'; ?>