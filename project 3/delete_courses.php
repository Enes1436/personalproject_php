<?php
require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare(
"DELETE FROM courses WHERE id=?"
);

$stmt->execute([$id]);

header("Location:courses.php");