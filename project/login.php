<?php
include 'config.php';
include 'functions.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST['login'])) {

    $email = clean($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT id, fullname, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Wrong password!";
        }

    } else {
        $message = "User not found!";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rent A Car</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" style="max-width: 800px; margin: 50px auto;">
    <header>
        <h1>🔐 Login</h1>
    </header>

    <main class="auth-container">
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'successful') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="link-group">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> Rent A Car System. All rights reserved.
    </footer>
</div>
</body>
</html>