<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "projectphp";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ensure users table exists
$create_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if (!mysqli_query($conn, $create_users)) {
    error_log('Failed to ensure users table: ' . mysqli_error($conn));
}

// ensure cars table exists
$create = "CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_name VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    description TEXT DEFAULT NULL,
    available TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if (!mysqli_query($conn, $create)) {
    error_log('Failed to ensure cars table: ' . mysqli_error($conn));
}

session_start();

?>
