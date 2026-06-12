<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $pageTitle ?? 'Rent A Car Shqipëria' ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <div style="display:flex;align-items:center;gap:12px;justify-content:space-between;width:100%">
      <a href="index.php" class="logo">🚗 RentACar</a>
      <button class="nav-toggle" aria-controls="main-nav" aria-expanded="false">☰</button>
    </div>
    <nav id="main-nav" class="nav-menu">
      <a href="index.php">Makinat</a>
      <a href="about.php">Rreth nesh</a>
      <a href="contact.php">Kontakt</a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="user_logout.php">Dil (<?= htmlspecialchars($_SESSION['user_fullname']) ?>)</a>
      <?php else: ?>
        <a href="user_login.php">Hyr</a>
        <a href="user_register.php">Regjistrohu</a>
      <?php endif; ?>
      <a href="login.php" class="btn-ghost">Admin</a>
    </nav>
  </div>
</header>
<main class="container">