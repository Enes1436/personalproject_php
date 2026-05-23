<?php
include 'config.php';
include 'functions.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST['register'])) {

    $fullname = clean($_POST['fullname']);
    $email = clean($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users(fullname, email, password) VALUES(?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Registration successful! You can now login.";
    } else {
        if (strpos(mysqli_error($conn), 'Duplicate') !== false) {
            $message = "Email already registered!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rent A Car</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" style="max-width: 800px; margin: 50px auto;">
    <header>
        <h1>✍️ Register</h1>
    </header>

    <main class="auth-container">
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'successful') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter a strong password" required>
            </div>

            <button type="submit" name="register">Register</button>
        </form>

        <div class="link-group">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> Rent A Car System. All rights reserved.
    </footer>
</div>
</body>
</html>