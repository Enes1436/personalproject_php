<?php
$page = 'Bookings';
require_once __DIR__ . '/header.php';
require_admin();

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    if (in_array($status, ['pending','confirmed','cancelled','completed'])) {
        $pdo->prepare("UPDATE bookings SET status=? WHERE id=?")->execute([$status,$id]);
        flash('success','Booking updated.');
    }
    redirect('bookings.php');
}
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([(int)$_GET['delete']]);
    flash('success','Booking deleted.');
    redirect('bookings.php');
}

$bookings = $pdo->query("SELECT b.*, c.brand, c.model FROM bookings b JOIN cars c ON c.id=b.car_id ORDER BY b.created_at DESC")->fetchAll();
?>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <div class="admin-content">
    <h2 class="fw-bold mb-1">Bookings</h2>
    <p class="text-secondary">Manage customer reservations</p>

    <div class="table-dark-app mt-3">
      <table class="table align-middle">
        <thead><tr><th>Customer</th><th>Car</th><th>Dates</th><th>Total</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($bookings as $b): ?>
          <tr>
            <td><?= e($b['full_name']) ?><br><small class="text-secondary"><?= e($b['email']) ?> · <?= e($b['phone']) ?></small></td>
            <td class="fw-semibold"><?= e($b['brand'].' '.$b['model']) ?></td>
            <td><?= e($b['pickup_date']) ?> → <?= e($b['return_date']) ?></td>
            <td class="fw-bold text-warning">$<?= number_format($b['total_price'],2) ?></td>
            <td>
              <form method="post" class="d-flex gap-1">
                <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                <select name="status" class="form-select form-select-sm" style="min-width:130px">
                  <?php foreach (['pending','confirmed','cancelled','completed'] as $st): ?>
                    <option <?= $b['status']===$st?'selected':'' ?>><?= $st ?></option>
                  <?php endforeach; ?>
                </select>
                <button name="update_status" value="1" class="btn btn-sm btn-primary-grad"><i class="bi bi-check"></i></button>
              </form>
            </td>
            <td class="text-end">
              <a href="bookings.php?delete=<?= (int)$b['id'] ?>" onclick="return confirm('Delete booking?')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$bookings): ?><tr><td colspan="6" class="text-center text-secondary py-4">No bookings yet.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
