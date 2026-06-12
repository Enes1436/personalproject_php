<?php
require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare(
"SELECT * FROM students WHERE id=?"
);

$stmt->execute([$id]);

$student = $stmt->fetch();

if(isset($_POST['update']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    $update = $pdo->prepare(
    "UPDATE students
    SET fullname=?,
        email=?,
        phone=?,
        course=?
    WHERE id=?"
    );

    $update->execute([
        $fullname,
        $email,
        $phone,
        $course,
        $id
    ]);

    header("Location: students.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Edit Student</h2>

<form method="POST">

<input
type="text"
name="fullname"
value="<?= $student['fullname'] ?>"
class="form-control mb-3">

<input
type="email"
name="email"
value="<?= $student['email'] ?>"
class="form-control mb-3">

<input
type="text"
name="phone"
value="<?= $student['phone'] ?>"
class="form-control mb-3">

<input
type="text"
name="course"
value="<?= $student['course'] ?>"
class="form-control mb-3">

<button
name="update"
class="btn btn-primary">
Update
</button>

</form>

</div>

</body>
</html>