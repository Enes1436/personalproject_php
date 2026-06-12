<?php
$page = 'Manage Cars';
require_once __DIR__ . '/header.php';
require_admin();

// DELETE action
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM cars WHERE id = ?")->execute([$id]);
    flash('success','Car deleted.');
    redirect('cars.php');
}

$cars = $pdo->query("SELECT * FROM cars ORDER BY created_at DESC")->fetchAll();
?>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div><h2 class="fw-bold mb-0">Cars</h2><p class="text-secondary mb-0">Manage your fleet</p></div>
      <a href="car_form.php" class="btn btn-primary-grad"><i class="bi bi-plus-lg"></i> Add Car</a>
    </div>

    <div class="table-dark-app">
      <table class="table align-middle">
        <thead><tr><th>Image</th><th>Car</th><th>Category</th><th>Price/day</th><th>Available</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($cars as $c): ?>
          <tr>
            <td><img src="<?= e(car_image_url($c['image'])) ?>" style="width:80px;height:55px;object-fit:cover;border-radius:8px"></td>
            <td class="fw-semibold"><?= e($c['brand'].' '.$c['model']) ?><br><small class="text-secondary"><?= e($c['year']) ?></small></td>
            <td><span class="badge bg-secondary"><?= e($c['category']) ?></span></td>
            <td class="text-warning fw-bold">$<?= number_format($c['price_per_day'],2) ?></td>
            <td>
              <?php if ($c['available']): ?>
                <span class="badge bg-success">Yes</span>
              <?php else: ?>
                <span class="badge bg-danger">No</span>
              <?php endif; ?>
            </td>
            <td class="text-end">
              <a href="car_form.php?id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-outline-light"><i class="bi bi-pencil"></i></a>
              <a href="cars.php?delete=<?= (int)$c['id'] ?>" onclick="return confirm('Delete this car?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$cars): ?><tr><td colspan="6" class="text-center text-secondary py-4">No cars yet.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>