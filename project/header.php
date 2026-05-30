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
  <div class="container nav">
    <a href="index.php" class="logo">🚗 RentACar</a>
    <nav>
      <a href="index.php">Makinat</a>
      <a href="about.php">Rreth nesh</a>
      <a href="contact.php">Kontakt</a>
      <a href="login.php" class="btn-ghost">Admin</a>
    </nav>
  </div>
</header>
<main class="container">