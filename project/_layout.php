<?php
require __DIR__.'/auth.php';
// Përdoret pas auth.php — pret $pageTitle dhe $active
include __DIR__.'/header.php';
?>
<div class="admin-layout">
  <aside class="sidebar">
    <p style="color:#fbbf24;margin-bottom:14px">👤 <?= htmlspecialchars(
      $_SESSION['admin_name']
    ) ?></p>
    <a href="dashboard.php" class="<?= ($active??'')==='dash'?'active':'' ?>">📊 Dashboard</a>
    <a href="cars.php" class="<?= ($active??'')==='cars'?'active':'' ?>">🚗 Makinat</a>
    <a href="bookings.php" class="<?= ($active??'')==='book'?'active':'' ?>">📅 Rezervimet</a>
    <a href="logout.php">🚪 Dil</a>
  </aside>
  <section>
