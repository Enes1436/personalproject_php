<?php
require __DIR__.'/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$error='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === '' || $password === '') {
        $error = 'Email dhe fjalëkalim kërkohen.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            // support both fullname and name column
            if (isset($user['fullname'])) $_SESSION['user_fullname'] = $user['fullname'];
            elseif (isset($user['name'])) $_SESSION['user_fullname'] = $user['name'];
            else $_SESSION['user_fullname'] = '';
            header('Location: index.php'); exit;
        } else {
            $error = 'Email ose fjalëkalim i pasaktë.';
        }
    }
}
include __DIR__.'/header.php';
?>
<h1>Hyr si Përdorues</h1>
<?php if($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" style="max-width:520px;background:#fff;padding:18px;border-radius:10px">
  <label>Email</label>
  <input name="email" type="email" required>
  <label style="margin-top:8px">Fjalëkalimi</label>
  <input name="password" type="password" required>
  <div style="margin-top:12px"><button class="btn" type="submit">Hyr</button> <a class="btn btn-secondary" href="user_register.php">Regjistrohu</a></div>
</form>
<?php include __DIR__.'/footer.php'; ?>
