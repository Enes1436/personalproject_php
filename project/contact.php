<?php
$pageTitle='Kontakt'; include __DIR__.'/header.php';

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
    $to = 'info@rentacar.al';
    $subject = 'Kontakt nga faqja — ' . ($name ?: 'Anonim');
    $body = "Emri: $name\nEmail: $email\n\nMesazhi:\n$message\n";
    $headers = "From: $name <$email>\r\nReply-To: $email\r\n";
    // Attempt to send mail; may fail on some local dev setups
    if(@mail($to, $subject, $body, $headers)){
      $sent = true;
    } else {
      $error = 'Dështoi dërgimi i mesazhit. Mund të na telefononi në +355 69 123 4567.';
    }
  }
}
?>

<h1>Na Kontaktoni</h1>

<?php if($sent): ?>
  <div class="alert alert-success">Faleminderit! Mesazhi u dërgua, ne do t'ju kontaktojmë së shpejti.</div>
<?php elseif($error): ?>
  <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:920px;margin-top:12px">
  <div class="panel">
    <h2>Informacione Kontakti</h2>
    <p><strong>📍 Adresa:</strong><br>Rruga e Durrësit, Tiranë</p>
    <p><strong>📞 Telefon:</strong><br>+355 69 123 4567</p>
    <p><strong>✉️ Email:</strong><br>info@rentacar.al</p>
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