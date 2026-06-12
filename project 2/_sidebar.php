<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar">
  <a href="dashboard.php" class="<?= $current==='dashboard.php'?'active':'' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="cars.php" class="<?= in_array($current,['cars.php','car_form.php'])?'active':'' ?>"><i class="bi bi-car-front"></i> Cars</a>
  <a href="bookings.php" class="<?= $current==='bookings.php'?'active':'' ?>"><i class="bi bi-calendar-check"></i> Bookings</a>
  <a href="../index.php"><i class="bi bi-house"></i> View Site</a>
  <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</aside>