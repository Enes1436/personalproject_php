<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$page = $page ?? 'Home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($page) ?> | DriveLux Rent A Car</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top app-nav">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">
      <i class="bi bi-car-front-fill text-warning"></i> DriveLux
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/cars.php">Cars</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/index.php#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/index.php#contact">Contact</a></li>
        <?php if (is_admin()): ?>
          <li class="nav-item"><a class="btn btn-warning fw-semibold px-3" href="<?= BASE_URL ?>/admin/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-outline-light px-3" href="<?= BASE_URL ?>/login.php">Admin Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="app-main">
<?php if ($msg = flash('success')): ?>
  <div class="container mt-3"><div class="alert alert-success"><?= e($msg) ?></div></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
  <div class="container mt-3"><div class="alert alert-danger"><?= e($msg) ?></div></div>
<?php endif; ?>