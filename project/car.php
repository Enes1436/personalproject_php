<?php
require __DIR__.'/config/db.php';
session_start();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id=?");
$stmt->execute([$id]);
$car = $stmt->fetch();
if (!$car) { http_response_code(404); die('Makina nuk u gjet.'); }

$success = $_SESSION['booking_success'] ?? null;
unset($_SESSION['booking_success']);

$pageTitle = $car['brand'].' '.$car['model'].' - Rezervo';
include 'includes/header.php';
?>

<?php if ($success): ?>
  <div class="alert alert-success">✅ Rezervimi u krye me sukses! Numri i rezervimit: #<?= $success ?>. Do t'ju kontaktojmë së shpejti.</div>
<?php endif; ?>

<div class="detail">
  <div class="img" <?php if($car['image']): ?>style="background-image:url('uploads/<?= htmlspecialchars($car['image']) ?>')"<?php endif; ?>></div>
  <div>
    <h1><?= htmlspecialchars($car['brand'].' '.$car['model']) ?></h1>
    <p style="color:#64748b;margin:8px 0 14px"><?= htmlspecialchars($car['description']) ?></p>
    <div class="specs">
      <div><strong>Viti:</strong> <?= $car['year'] ?></div>
      <div><strong>Kambio:</strong> <?= htmlspecialchars($car['transmission']) ?></div>
      <div><strong>Karburant:</strong> <?= htmlspecialchars($car['fuel']) ?></div>
      <div><strong>Vende:</strong> <?= $car['seats'] ?></div>
    </div>
    <div style="font-size:1.6rem;font-weight:700;color:#0f172a">€<?= number_format($car['price_per_day'],2) ?> <span style="color:#64748b;font-weight:400;font-size:.9rem">/ ditë</span></div>
  </div>
</div>

<form class="booking" method="post" action="book.php">
  <h2>Rezervo Tani</h2>
  <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
  <input type="hidden" name="price" value="<?= $car['price_per_day'] ?>">
  <div class="form-row">
    <div><label>Emri i plotë</label><input type="text" name="full_name" required></div>
    <div><label>Telefon</label><input type="text" name="phone" required></div>
  </div>
  <div class="form-row">
    <div><label>Email</label><input type="email" name="email" required></div>
    <div></div>
  </div>
  <div class="form-row">
    <div><label>Data e fillimit</label><input type="date" name="start_date" id="sd" min="<?= date('Y-m-d') ?>" required></div>
    <div><label>Data e mbarimit</label><input type="date" name="end_date" id="ed" min="<?= date('Y-m-d') ?>" required></div>
  </div>
  <div id="total" style="margin:10px 0;font-weight:600"></div>
  <button class="btn btn-block" type="submit">Dërgo Rezervimin</button>
</form>

<script>
const price = <?= $car['price_per_day'] ?>;
const sd = document.getElementById('sd'), ed = document.getElementById('ed'), tot = document.getElementById('total');
function calc(){
  if(!sd.value||!ed.value)return;
  const d1=new Date(sd.value),d2=new Date(ed.value);
  const days=Math.ceil((d2-d1)/(1000*60*60*24));
  if(days>0) tot.textContent='Total: €'+(days*price).toFixed(2)+' për '+days+' ditë';
  else tot.textContent='';
}
sd.addEventListener('change',calc); ed.addEventListener('change',calc);
</script>

<?php include 'includes/footer.php'; ?>