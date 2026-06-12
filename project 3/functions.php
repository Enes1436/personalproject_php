<?php

function totalStudents($pdo)
{
    return $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
}

function totalCourses($pdo)
{
    return $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
}

function greeting($name)
{
    return "Welcome " . $name;
}
?>