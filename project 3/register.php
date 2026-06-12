<?php
require 'config.php';

$message = "";

if(isset($_POST['register']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(fullname,email,password)
            VALUES(?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fullname,$email,$password]);

    $message = "Registration successful!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Register</h2>

<?php if($message): ?>
<div class="alert alert-success">
    <?= $message ?>
</div>
<?php endif; ?>

<form method="POST">

<input type="text"
name="fullname"
class="form-control mb-3"
placeholder="Full Name"
required>

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
name="register"
class="btn btn-primary">
Register
</button>

<a href="login.php">Login</a>

</form>

</div>

</body>
</html>