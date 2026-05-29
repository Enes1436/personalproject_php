<?php
require __DIR__.'/auth.php';

if (isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->execute([$_POST['status'], (int)$_POST['id']]);
    header('Location: bookings.php'); exit;
}
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([(int)$_GET['delete']]);
    header('Location: bookings.php'); exit;
}

$rows = $pdo->query("SELECT b.*, c.brand, c.model FROM bookings b LEFT JOIN cars c ON c.id=b.car_id ORDER BY b.created_at DESC")->fetchAll();
$pageTitle='Rezervimet'; $active='book';
include '_layout.php';
?>
<h1>Rezervimet</h1>
<table style="margin-top:18px">
  <tr><th>#</th><th>Klienti</th><th>Makina</th><th>Periudha</th><th>Total</th><th>Statusi</th><th>Veprime</th></tr>
  <?php foreach($rows as $r): ?>
    <tr>
      <td>#<?= $r['id'] ?></td>
      <td><?= htmlspecialchars($r['full_name']) ?><br><small><?= htmlspecialchars($r['email']) ?> · <?= htmlspecialchars($r['phone']) ?></small></td>
      <td><?= htmlspecialchars(($r['brand']??'').' '.($r['model']??'')) ?></td>
      <td><?= $r['start_date'] ?><br>→ <?= $r['end_date'] ?></td>
      <td>€<?= number_format($r['total_price'],2) ?></td>
      <td>
        <?php $cls=['Ne pritje'=>'badge-pending','Konfirmuar'=>'badge-ok','Anulluar'=>'badge-cancel'][$r['status']]; ?>
        <span class="badge <?= $cls ?>"><?= $r['status'] ?></span>
      </td>
      <td>
        <form method="post" style="display:inline-flex;gap:4px">
          <input type="hidden" name="id" value="<?= $r['id'] ?>">
          <select name="status"><?php foreach(['Ne pritje','Konfirmuar','Anulluar'] as $s): ?><option <?= $r['status']===$s?'selected':'' ?>><?= $s ?></option><?php endforeach; ?></select>
          <button class="btn" name="update_status">Ruaj</button>
        </form>
        <a class="btn btn-danger" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Fshij?')">Fshi</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include '_layout_end.php'; ?>