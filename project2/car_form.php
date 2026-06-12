<?php
$page = 'Car Form';
require_once __DIR__ . '/header.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$car = ['id'=>0,'brand'=>'','model'=>'','year'=>date('Y'),'category'=>'Sedan','transmission'=>'Manual','fuel'=>'Petrol','seats'=>5,'price_per_day'=>50,'image'=>'','description'=>'','available'=>1];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE id=?");
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if ($found) $car = $found;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car['brand']       = trim($_POST['brand'] ?? '');
    $car['model']       = trim($_POST['model'] ?? '');
    $car['year']        = (int)($_POST['year'] ?? 0);
    $car['category']    = trim($_POST['category'] ?? '');
    $car['transmission']= $_POST['transmission'] ?? 'Manual';
    $car['fuel']        = trim($_POST['fuel'] ?? '');
    $car['seats']       = (int)($_POST['seats'] ?? 5);
    $car['price_per_day']= (float)($_POST['price_per_day'] ?? 0);
    $car['description'] = trim($_POST['description'] ?? '');
    $car['available']   = isset($_POST['available']) ? 1 : 0;

    if (!$car['brand'])  $errors[] = 'Brand required.';
    if (!$car['model'])  $errors[] = 'Model required.';
    if ($car['year']<1950 || $car['year']>date('Y')+1) $errors[] = 'Invalid year.';
    if ($car['price_per_day']<=0) $errors[] = 'Price must be positive.';

    $newImage = upload_image('image');
    if ($newImage) $car['image'] = $newImage;

    if (!$errors) {
        if ($id) {
            $sql = "UPDATE cars SET brand=?,model=?,year=?,category=?,transmission=?,fuel=?,seats=?,price_per_day=?,image=?,description=?,available=? WHERE id=?";
            $pdo->prepare($sql)->execute([$car['brand'],$car['model'],$car['year'],$car['category'],$car['transmission'],$car['fuel'],$car['seats'],$car['price_per_day'],$car['image'],$car['description'],$car['available'],$id]);
            flash('success','Car updated.');
        } else {
            $sql = "INSERT INTO cars (brand,model,year,category,transmission,fuel,seats,price_per_day,image,description,available) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $pdo->prepare($sql)->execute([$car['brand'],$car['model'],$car['year'],$car['category'],$car['transmission'],$car['fuel'],$car['seats'],$car['price_per_day'],$car['image'],$car['description'],$car['available']]);
            flash('success','Car added.');
        }
        redirect('cars.php');
    }
}
?>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="admin-content">
    <a href="cars.php" class="text-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    <h2 class="fw-bold mt-2 mb-4"><?= $id ? 'Edit Car' : 'Add New Car' ?></h2>

    <?php if ($errors): ?><div class="alert alert-danger"><?php foreach ($errors as $err) echo '<div>'.e($err).'</div>'; ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="search-card">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Brand</label><input name="brand" value="<?= e($car['brand']) ?>" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Model</label><input name="model" value="<?= e($car['model']) ?>" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Year</label><input type="number" name="year" value="<?= (int)$car['year'] ?>" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Category</label>
          <select name="category" class="form-select">
            <?php foreach (['Economy','Sedan','SUV','Electric','Luxury','Sports','Van'] as $c): ?>
              <option <?= $car['category']===$c?'selected':'' ?>><?= $c ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4"><label class="form-label">Transmission</label>
          <select name="transmission" class="form-select">
            <option <?= $car['transmission']==='Manual'?'selected':'' ?>>Manual</option>
            <option <?= $car['transmission']==='Automatic'?'selected':'' ?>>Automatic</option>
          </select>
        </div>
        <div class="col-md-4"><label class="form-label">Fuel</label><input name="fuel" value="<?= e($car['fuel']) ?>" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Seats</label><input type="number" name="seats" value="<?= (int)$car['seats'] ?>" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Price / day ($)</label><input type="number" step="0.01" name="price_per_day" value="<?= e($car['price_per_day']) ?>" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Description</label><textarea name="description" rows="4" class="form-control"><?= e($car['description']) ?></textarea></div>
        <div class="col-md-8"><label class="form-label">Image (jpg/png/webp)</label><input type="file" name="image" accept="image/*" class="form-control">
          <?php if ($car['image']): ?><img src="<?= e(car_image_url($car['image'])) ?>" class="mt-2 rounded" style="height:80px"><?php endif; ?>
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="available" id="av" <?= $car['available']?'checked':'' ?> >
            <label class="form-check-label" for="av">Available for rent</label>
          </div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary-grad"><i class="bi bi-check-lg"></i> Save Car</button>
        <a href="cars.php" class="btn btn-ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
