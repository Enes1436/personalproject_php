<?php
// Helper functions

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function flash($key, $message = null) {
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return;
    }
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function require_admin() {
    if (!is_admin()) {
        redirect('login.php');
    }
}

// Calculate number of days between two dates
function days_between($start, $end) {
    $d1 = new DateTime($start);
    $d2 = new DateTime($end);
    $diff = $d1->diff($d2)->days;
    return max(1, (int)$diff);
}

// Calculate booking total with simple loop / conditional rules
function calculate_total($price_per_day, $start, $end) {
    $days = days_between($start, $end);
    $total = 0;
    for ($i = 1; $i <= $days; $i++) {
        // 10% discount per day for stays of 7+ days
        if ($days >= 7) {
            $total += $price_per_day * 0.9;
        } else {
            $total += $price_per_day;
        }
    }
    return round($total, 2);
}

function upload_image($field = 'image') {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['jpg','jpeg','png','webp','gif'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        return null;
    }
    if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0777, true);
    $name = uniqid('car_') . '.' . $ext;
    if (move_uploaded_file($_FILES[$field]['tmp_name'], UPLOAD_DIR . $name)) {
        return $name;
    }
    return null;
}

function car_image_url($image) {
    if (!$image) return 'https://images.unsplash.com/photo-1502877338535-766e1452684a?w=800&q=80';
    if (strpos($image, 'http') === 0) return $image;
    if (file_exists(UPLOAD_DIR . $image)) return UPLOAD_URL . $image;
    // fallback sample images
    return 'https://images.unsplash.com/photo-1542362567-b07e54358753?w=800&q=80';
}
