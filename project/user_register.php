<?php
require __DIR__.'/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$error=''; $success='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($fullname === '' || $email === '' || $password === '') {
        $error = 'Ju lutem plotësoni të gjitha fushat.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email i pavlefshëm.';
    } else {
        // ensure users table exists (create minimal if absent)
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(120) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // determine name column (fullname vs name)
        $colsStmt = $pdo->query("SHOW COLUMNS FROM users");
        $cols = $colsStmt->fetchAll(PDO::FETCH_COLUMN,0);
        if (in_array('fullname', $cols)) {
            $nameCol = 'fullname';
        } elseif (in_array('name', $cols)) {
            $nameCol = 'name';
        } else {
            // add fullname column
            try {
                $pdo->exec("ALTER TABLE users ADD COLUMN fullname VARCHAR(120) DEFAULT NULL");
                $nameCol = 'fullname';
            } catch (Exception $e) {
                // fallback to using no name column
                $nameCol = null;
            }
        }

        // check existing
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email=?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Ky email është përdorur tashmë.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if ($nameCol) {
                $pdo->prepare("INSERT INTO users ($nameCol,email,password) VALUES (?,?,?)")
                    ->execute([$fullname,$email,$hash]);
            } else {
                // insert without fullname
                $pdo->prepare('INSERT INTO users (email,password) VALUES (?,?)')
                    ->execute([$email,$hash]);
                // attempt to set fullname after insert
                $newId = $pdo->lastInsertId();
                if ($newId) {
                    $pdo->prepare('UPDATE users SET fullname=? WHERE id=?')->execute([$fullname,$newId]);
                }
            }
            $success = 'Regjistrimi u krye. Tani mund të hyni.';
        }
    }
}
include __DIR__.'/header.php';
?>
<h1>Regjistrohu</h1>
<?php if($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
<form method="post" style="max-width:520px;background:#fff;padding:18px;border-radius:10px">
  <label>Emri i plotë</label>
  <input name="fullname" required>
  <label style="margin-top:8px">Email</label>
  <input name="email" type="email" required>
  <label style="margin-top:8px">Fjalëkalimi</label>
  <input name="password" type="password" required>
  <div style="margin-top:12px"><button class="btn" type="submit">Regjistrohu</button></div>
</form>
<?php include __DIR__.'/footer.php'; ?>
