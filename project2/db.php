<?php
// PDO Database connection
// Update credentials to match your local environment (XAMPP defaults below)

define('DB_HOST', 'localhost');
define('DB_NAME', 'rentacar1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Base URL for links for the renamed folder
define('BASE_URL', 'http://localhost/personalproject_php/project2');
// Upload directory and URL (store uploads inside this project folder)
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', BASE_URL . '/uploads/');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
