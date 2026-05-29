<?php
require __DIR__.'/config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }

$carId = (int)($_POST['car_id'] ?? 0);
$name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$start = $_POST['start_date'] ?? '';
$end = $_POST['end_date'] ?? '';

if (!$carId || !$name || !$email || !$phone || !$start || !$end) {
    die('Plotëso të gjitha fushat.');
}

$d1 = strtotime($start); $d2 = strtotime($end);
if ($d2 <= $d1) die('Data e mbarimit duhet pas datës së fillimit.');

$stmt = $pdo->prepare("SELECT price_per_day FROM cars WHERE id=?");
$stmt->execute([$carId]);
$car = $stmt->fetch();
if (!$car) die('Makina nuk ekziston.');

$days = ceil(($d2-$d1)/86400);
$total = $days * $car['price_per_day'];

$ins = $pdo->prepare("INSERT INTO bookings (car_id,full_name,email,phone,start_date,end_date,total_price) VALUES (?,?,?,?,?,?,?)");
$ins->execute([$carId,$name,$email,$phone,$start,$end,$total]);

$_SESSION['booking_success'] = $pdo->lastInsertId();
header("Location: car.php?id=$carId");
exit;