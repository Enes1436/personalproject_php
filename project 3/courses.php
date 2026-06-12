<?php
require 'config.php';

$courses = $pdo->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
<title>Courses</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Courses</h2>

<a href="add_course.php" class="btn btn-success">
Add Course
</a>

<table class="table mt-3">

<tr>
<th>ID</th>
<th>Course</th>
<th>Description</th>
<th>Action</th>
</tr>

<?php while($row = $courses->fetch(PDO::FETCH_ASSOC)): ?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['course_name'] ?></td>
<td><?= $row['description'] ?></td>
<td>

<a href="edit_course.php?id=<?= $row['id'] ?>"
class="btn btn-warning">
Edit
</a>

<a href="delete_course.php?id=<?= $row['id'] ?>"
class="btn btn-danger">
Delete
</a>

</td>
</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>