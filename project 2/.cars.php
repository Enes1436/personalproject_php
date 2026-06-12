<?php
$page = 'Cars';
require_once __DIR__ . '/includes/header.php';

// Filters
$category = $_GET['category'] ?? '';
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 500;
$search = trim($_GET['q'] ?? '');

$sql = "SELECT * FROM cars WHERE available = 1 AND price_per_day <= :max";
$params = [':max' => $max_price];
if ($category !== '') { $sql .= " AND category = :cat"; $params[':cat'] = $category; }
if ($search !== '')   { $sql .= " AND (brand LIKE :q OR model LIKE :q)"; $params[':q'] = "%$search%"; }
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cars = $stmt->fetchAll();

$cats = $pdo->query("SELECT DISTINCT category FROM cars ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>

<section style="padding-top:3rem">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
      <div>
        <h2 class="section-title">Our Fleet</h2>
        <p class="section-sub mb-0"><?= count($cars) ?> car<?= count($cars)===1?'':'s' ?> available</p>
      </div>
    </div>

    <form class="search-card mb-5" method="get">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Search</label>
          <input type="text" name="q" value="<?= e($search) ?>" class="form-control" placeholder="Brand or model...">
        </div>
        <div class="col-md-3">
          <label class="form-label">Category</label>
          <select name="category" class="form-select">
            <option value="">All</option>
            <?php foreach ($cats as $c): ?>
              <option <?= $category===$c?'selected':'' ?>><?= e($c) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Max price: <span id="pl" class="text-warning fw-bold">$<?= (int)$max_price ?></span></label>
          <input type="range" name="max_price" min="20" max="500" step="10" value="<?= (int)$max_price ?>" class="form-range" oninput="document.getElementById('pl').textContent='$'+this.value">
        </div>
        <div class="col-md-2"><button class="btn btn-primary-grad w-100">Filter</button></div>
      </div>
    </form>

    <?php if (!$cars): ?>
      <div class="text-center py-5"><i class="bi bi-emoji-frown display-1 text-secondary"></i><p class="mt-3 text-secondary">No cars match your filters.</p></div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($cars as $car): ?>
          <div class="col-sm-6 col-lg-4 fade-up">
            <div class="car-card">
              <div class="img">
                <span class="badge-cat"><?= e($car['category']) ?></span>
                <img src="<?= e(car_image_url($car['image'])) ?>" alt="<?= e($car['brand']) ?>">
              </div>
              <div class="body">
                <h5><?= e($car['brand'].' '.$car['model']) ?></h5>
                <small class="text-secondary"><?= e($car['year']) ?></small>
                <div class="meta">
                  <span><i class="bi bi-people"></i> <?= (int)$car['seats'] ?></span>
                  <span><i class="bi bi-fuel-pump"></i> <?= e($car['fuel']) ?></span>
                  <span><i class="bi bi-gear"></i> <?= e($car['transmission']) ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                  <div class="price">$<?= number_format($car['price_per_day'],2) ?> <small>/day</small></div>
                  <a href="car.php?id=<?= (int)$car['id'] ?>" class="btn btn-primary-grad btn-sm">Details</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>