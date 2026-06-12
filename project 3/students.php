<?php
require 'config.php';

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit;
}

$students = $pdo->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Students</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Students Management</h2>

<a href="dashboard.php" class="btn btn-secondary">Dashboard</a>

<a href="add_student.php" class="btn btn-success">
Add Student
</a>

<hr>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Phone</th>
<th>Course</th>
<th>Actions</th>
</tr>

<?php while($row = $students->fetch(PDO::FETCH_ASSOC)): ?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['fullname'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['course'] ?></td>

<td>

<a href="edit_student.php?id=<?= $row['id'] ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="delete_student.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm">
Delete
</a>

</td>
</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>