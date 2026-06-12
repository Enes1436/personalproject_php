<?php
require 'config.php';

if(isset($_POST['save']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    $stmt = $pdo->prepare(
    "INSERT INTO students(fullname,email,phone,course)
     VALUES(?,?,?,?)"
    );

    $stmt->execute([
        $fullname,
        $email,
        $phone,
        $course
    ]);

    header("Location: students.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Add Student</h2>

<form method="POST">

<input type="text"
name="fullname"
class="form-control mb-3"
placeholder="Full Name"
required>

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input type="text"
name="phone"
class="form-control mb-3"
placeholder="Phone">

<input type="text"
name="course"
class="form-control mb-3"
placeholder="Course">

<button name="save"
class="btn btn-success">
Save
</button>

</form>

</div>

</body>
</html>