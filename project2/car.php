<?php
$page = 'Car Details';
require_once __DIR__ . '/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch();
if (!$car) { echo '<div class="container py-5"><div class="alert alert-danger">Car not found.</div></div>'; require __DIR__ . '/footer.php'; exit; }

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pickup = $_POST['pickup_date'] ?? '';
    $return = $_POST['return_date'] ?? '';

    if (!$name)  $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (!$phone) $errors[] = 'Phone is required.';
    if (!$pickup || !$return) $errors[] = 'Pickup and return dates are required.';
    if ($pickup && $return && strtotime($return) <= strtotime($pickup)) $errors[] = 'Return date must be after pickup.';

    if (!$errors) {
        $total = calculate_total($car['price_per_day'], $pickup, $return);
        $ins = $pdo->prepare("INSERT INTO bookings (car_id, full_name, email, phone, pickup_date, return_date, total_price) VALUES (?,?,?,?,?,?,?)");
        $ins->execute([$car['id'], $name, $email, $phone, $pickup, $return, $total]);
        flash('success', "Booking confirmed! Total: $" . number_format($total,2) . ". We'll email you shortly.");
        redirect("car.php?id={$car['id']}#book");
    }
}
?>

<section style="padding-top:3rem">
  <div class="container">
    <a href="cars.php" class="text-secondary"><i class="bi bi-arrow-left"></i> Back to cars</a>
    <div class="row g-5 mt-2">
      <div class="col-lg-7">
        <div class="rounded-4 overflow-hidden" style="background:#0e1420">
          <img src="<?= e(car_image_url($car['image'])) ?>" class="w-100" style="aspect-ratio:16/10;object-fit:cover">
        </div>
        <div class="mt-4">
          <span class="badge bg-warning text-dark px-3 py-2"><?= e($car['category']) ?></span>
          <h1 class="fw-bold mt-3"><?= e($car['brand'].' '.$car['model']) ?></h1>
          <p class="text-secondary"><?= e($car['year']) ?> · <?= e($car['transmission']) ?> · <?= e($car['fuel']) ?></p>
          <p class="mt-3"><?= nl2br(e($car['description'])) ?></p>

          <div class="row g-3 mt-3">
            <?php
            $specs = [
              ['bi-people','Seats',$car['seats']],
              ['bi-gear','Transmission',$car['transmission']],
              ['bi-fuel-pump','Fuel',$car['fuel']],
              ['bi-calendar','Year',$car['year']],
            ];
            foreach ($specs as $s): ?>
              <div class="col-6 col-md-3">
                <div class="feature text-center p-3">
                  <i class="bi <?= $s[0] ?> text-warning fs-3"></i>
                  <div class="small text-secondary mt-2"><?= e($s[1]) ?></div>
                  <div class="fw-bold"><?= e($s[2]) ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-5" id="book">
        <div class="search-card position-sticky" style="top:100px">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Book this car</h4>
            <div class="price text-warning fw-bold">$<?= number_format($car['price_per_day'],2) ?><small class="text-secondary">/day</small></div>
          </div>

          <?php if ($errors): ?>
            <div class="alert alert-danger"><?php foreach ($errors as $err) echo '<div>'.e($err).'</div>'; ?></div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3"><label class="form-label">Full Name</label><input name="full_name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Phone</label><input name="phone" class="form-control" required></div>
            <div class="row g-2 mb-3">
              <div class="col"><label class="form-label">Pick-up</label><input type="date" id="pickup_date" name="pickup_date" class="form-control" required></div>
              <div class="col"><label class="form-label">Return</label><input type="date" id="return_date" name="return_date" class="form-control" required></div>
            </div>
            <div class="alert alert-warning small mb-3"><i class="bi bi-info-circle"></i> 10% discount automatically applied for rentals of 7+ days.</div>
            <button class="btn btn-primary-grad w-100"><i class="bi bi-calendar-check"></i> Confirm Booking</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>