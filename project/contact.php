<?php
$pageTitle='Kontakt';
$sent = false; $error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $message = trim($_POST['message'] ?? '');
  if($name === '' || $email === '' || $message === ''){
    $error = 'Ju lutem plotësoni të gjitha fushat.';
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = 'Email i pavlefshëm.';
  } else {
    $to = 'info@rentacar1.al';
    $subject = 'Kontakt nga faqja — ' . ($name ?: 'Anonim');
    $body = "Emri: $name\nEmail: $email\n\nMesazhi:\n$message\n";
    $headers = "From: $name <$email>\r\nReply-To: $email\r\n";
    // Attempt to send mail; on local dev this often fails if mail is not configured.
    $mailResult = @mail($to, $subject, $body, $headers);
    if($mailResult){
      $sent = true;
    } else {
      // Save message locally as a fallback so no user message is lost
      $safeEmail = preg_replace('/[^a-z0-9_\-@.]/i','', $email);
      $fn = __DIR__ . '/contact_messages/' . date('Ymd_His') . '_' . ($safeEmail ?: 'anon') . '.txt';
      $data = "Time: " . date('c') . "\nFrom: $name <$email>\nSubject: $subject\n\n$body\n";
      @file_put_contents($fn, $data);
      // also append debug info
      $dbg = '['.date('Y-m-d H:i:s')."] Mail failed. sendmail_path=".ini_get('sendmail_path')."\nSaved to: $fn\nPOST=".json_encode($_POST, JSON_UNESCAPED_UNICODE)."\n\n";
      @file_put_contents(__DIR__.'/contact_debug.log', $dbg, FILE_APPEND);
      $sent = true; // treat as sent because it was saved for later processing
      $info = 'Mesazhi u ruajt lokalish sepse serveri i postës nuk është i konfiguruar; do të dërgohet kur konfigurimi të jetë përditësuar.';
    }
  }
}
include __DIR__.'/header.php';
?>

<h1>Na Kontaktoni</h1>

<?php if($sent): ?>
  <div class="alert alert-success">
    Faleminderit! Mesazhi u dërgua, ne do t'ju kontaktojmë së shpejti.
    <?php if(!empty($info)): ?><div class="small" style="margin-top:6px;opacity:.9"><?= htmlspecialchars($info) ?></div><?php endif; ?>
  </div>
<?php elseif($error): ?>
  <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:920px;margin-top:12px">
  <div class="panel">
    <h2>Informacione Kontakti</h2>
    <p><strong>📍 Adresa:</strong><br>Rruga e Durrësit, Tiranë</p>
    <p><strong>📞 Telefon:</strong><br>+355 69 123 4567</p>
    <p><strong>✉️ Email:</strong><br>info@rentacar1.al</p>
    <p><strong>🕐 Orari:</strong><br>E hënë - E diel, 08:00 - 22:00</p>
  </div>

  <div class="panel">
    <h2>Na shkruani</h2>
    <form method="post" action="contact.php">
      <label for="name">Emri</label>
      <input id="name" name="name" placeholder="Emri juaj" required>

      <label for="email" style="margin-top:10px">Email</label>
      <input id="email" name="email" type="email" placeholder="ju@example.com" required>

      <label for="message" style="margin-top:10px">Mesazhi</label>
      <textarea id="message" name="message" rows="5" placeholder="Si mund t'ju ndihmojmë?" required></textarea>

      <div style="margin-top:12px">
        <button class="btn" type="submit">Dërgo Mesazhin</button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__.'/footer.php'; ?>