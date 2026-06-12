<?php
require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare(
"SELECT * FROM courses WHERE id=?"
);

$stmt->execute([$id]);

$course = $stmt->fetch();

if(isset($_POST['update']))
{
    $stmt = $pdo->prepare(
    "UPDATE courses
    SET course_name=?,
        description=?
    WHERE id=?"
    );

    $stmt->execute([
        $_POST['course_name'],
        $_POST['description'],
        $id
    ]);

    header("Location:courses.php");
}
?>
<link rel="stylesheet" href="style.css">
<form method="POST">

<input
type="text"
name="course_name"
value="<?= $course['course_name'] ?>">

<br><br>

<textarea
name="description"><?= $course['description'] ?></textarea>

<br><br>

<button name="update">
Update
</button>

</form>