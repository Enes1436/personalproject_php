<?php
require 'config.php';

$error = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email=?"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if($user && password_verify($password,$user['password']))
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];

        header("Location: dashboard.php");
        exit;
    }
    else
    {
        $error = "Invalid login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">

<h2>Login</h2>

<?php if($error): ?>
<div class="alert alert-danger">
<?= $error ?>
</div>
<?php endif; ?>

<form method="POST">

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="login"
class="btn btn-success">
Login
</button>

</form>

</div>

</body>
</html>