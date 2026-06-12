<?php
$page = 'Login';
require_once __DIR__ . '/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    // Allow default seeded admin (admin123) OR password_verify
    if ($user && (password_verify($pass, $user['password']) || ($email === 'admin@rent.com' && $pass === 'admin123'))) {
        $_SESSION['user'] = ['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email'],'role'=>$user['role']];
        flash('success','Welcome back, '.$user['name'].'!');
        redirect($user['role']==='admin' ? 'admin/dashboard.php' : 'index.php');
    } else {
        $error = 'Invalid email or password.';
    }
}
?>

<section style="padding:5rem 0;min-height:80vh">
  <div class="container" style="max-width:440px">
    <div class="search-card">
      <h3 class="fw-bold mb-1">Admin Login</h3>
      <p class="text-secondary small mb-4">Sign in to manage cars and bookings.</p>
      <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="admin@rent.com" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" value="admin123" required></div>
        <button class="btn btn-primary-grad w-100">Sign In</button>
      </form>
      <p class="small text-secondary mt-3 mb-0">Default: <code>admin@rent.com</code> / <code>admin123</code></p>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>