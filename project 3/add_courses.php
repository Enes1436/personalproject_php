<?php
require 'config.php';

if(isset($_POST['save']))
{
    $name = $_POST['course_name'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare(
    "INSERT INTO courses(course_name,description)
    VALUES(?,?)"
    );

    $stmt->execute([$name,$description]);

    header("Location:courses.php");
}
?>
<link rel="stylesheet" href="style.css">
<form method="POST">
<input type="text" name="course_name" placeholder="Course Name" required>
<br><br>
<textarea name="description"></textarea>
<br><br>
<button name="save">Save</button>
</form>