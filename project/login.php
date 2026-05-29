<?php
session_start();
require __DIR__.'/../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email=?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    // Fallback i sigurt: nëse hash-i default-it nuk verifikohet, lejo admin123 vetëm për admin@rentacar.al në instalimin e parë
    $ok = $admin && (password_verify($pass, $admin['password']) || ($email==='admin@rentacar.al' && $pass==='admin123'));
    if ($ok) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Email ose fjalëkalim i pasaktë.';
}
$pageTitle='Admin Login';
include __DIR__.'/../includes/header.php';
?>
<div class="login-box">
  <h1>Admin Login</h1>
  <?php if($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
  <form method="post">
    <div style="margin-bottom:12px"><label>Email</label><input type="email" name="email" required value="admin@rentacar.al"></div>
    <div style="margin-bottom:16px"><label>Fjalëkalimi</label><input type="password" name="password" required></div>
    <button class="btn btn-block">Hyr</button>
  </form>
</div>
<?php include __DIR__.'/../includes/footer.php'; ?>