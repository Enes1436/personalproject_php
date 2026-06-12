<?php
require_once __DIR__ . '/header.php';
?>
<div class="container mt-5 pt-5">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <h1>Contact Us</h1>
      <p class="text-secondary">For demo purposes, this contact form does not send email. Use it to collect data or wire up a mailer.</p>
      <form method="post" action="contact.php">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input class="form-control" name="name">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="email">
        </div>
        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea class="form-control" name="message" rows="5"></textarea>
        </div>
        <button class="btn btn-primary">Send</button>
      </form>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
