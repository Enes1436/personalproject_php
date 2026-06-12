<?php
require 'config.php';
require 'functions.php';

$totalStudents = totalStudents($pdo);
$totalCourses = totalCourses($pdo);
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Reports</h2>

<div class="card p-3 mb-3">
Total Students:
<h1><?= $totalStudents ?></h1>
</div>

<div class="card p-3">
Total Courses:
<h1><?= $totalCourses ?></h1>
</div>

</div>

</body>
</html>