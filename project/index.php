<?php
require __DIR__.'/config/db.php';
$pageTitle = 'Makinat me Qira - RentACar';

$brand = trim($_GET['brand'] ?? '');
$maxPrice = $_GET['max_price'] ?? '';

$sql = "SELECT * FROM cars WHERE available=1";
$params = [];
if ($brand !== '') { $sql .= " AND brand LIKE ?"; $params[] = "%$brand%"; }
if ($maxPrice !== '' && is_numeric($maxPrice)) { $sql .= " AND price_per_day <= ?"; $params[] = $maxPrice; }
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cars = $stmt->fetchAll();

include 'includes/header.php';
?>
<section class="hero">
  <h1>Makina me Qira në Shqipëri</h1>
  <p>Çmime të volitshme, dorëzim falas në aeroport.</p>
</section>

<form class="filters" method="get">
  <input type="text" name="brand" placeholder="Marka (BMW, Audi...)" value="<?= htmlspecialchars($brand) ?>">
  <input type="number" name="max_price" placeholder="Çmimi max / ditë (€)" value="<?= htmlspecialchars($maxPrice) ?>">
  <button class="btn" type="submit">Filtro</button>
</form>

<?php if (empty($cars)): ?>
  <p>Asnjë makinë nuk u gjet.</p>
<?php else: ?>
<div class="cars-grid">
  <?php foreach ($cars as $c): ?>
    <a class="car-card" href="car.php?id=<?= $c['id'] ?>" style="text-decoration:none;color:inherit">
      <div class="img" <?php if($c['image']): ?>style="background-image:url('uploads/<?= htmlspecialchars($c['image']) ?>')"<?php endif; ?>></div>
      <div class="body">
        <h3><?= htmlspecialchars($c['brand'].' '.$c['model']) ?></h3>
        <div class="meta"><?= $c['year'] ?> · <?= htmlspecialchars($c['transmission']) ?> · <?= htmlspecialchars($c['fuel']) ?></div>
        <div class="price">€<?= number_format($c['price_per_day'],0) ?><span> / ditë</span></div>
      </div>
    </a>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>