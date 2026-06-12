<?php
require 'config.php';

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

$count = $pdo->query(
"SELECT COUNT(*) FROM students"
)->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">

<h1>
Welcome <?= $_SESSION['fullname']; ?>
</h1>

<a href="logout.php"
class="btn btn-danger">
Logout
</a>

<hr>

<div class="card p-4">

<h3>Total Students</h3>

<h1><?= $count ?></h1>

</div>

<br>

<a href="students.php"
class="btn btn-primary">
Manage Students
</a>

</div>

</body>
</html>