<?php
require __DIR__.'/auth.php';

$id = (int)($_GET['id'] ?? 0);
$car = ['id'=>0,'brand'=>'','model'=>'','year'=>date('Y'),'transmission'=>'Manual','fuel'=>'Benzine','seats'=>5,'price_per_day'=>'','description'=>'','available'=>1,'image'=>''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE id=?");
    $stmt->execute([$id]);
    $car = $stmt->fetch() ?: $car;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $data = [
        'brand'=>trim($_POST['brand']),
        'model'=>trim($_POST['model']),
        'year'=>(int)$_POST['year'],
        'transmission'=>$_POST['transmission'],
        'fuel'=>$_POST['fuel'],
        'seats'=>(int)$_POST['seats'],
        'price_per_day'=>(float)$_POST['price_per_day'],
        'description'=>trim($_POST['description']),
        'available'=>isset($_POST['available'])?1:0,
    ];

    $image = $car['image'];
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid('car_').'.'.$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../uploads/'.$image);
    }

    if ($id) {
        $sql = "UPDATE cars SET brand=:brand,model=:model,year=:year,transmission=:transmission,fuel=:fuel,seats=:seats,price_per_day=:price_per_day,description=:description,available=:available,image=:image WHERE id=:id";
        $data['id']=$id; $data['image']=$image;
        $pdo->prepare($sql)->execute($data);
    } else {
        $data['image']=$image;
        $cols=implode(',',array_keys($data));
        $ph=':'.implode(',:',array_keys($data));
        $pdo->prepare("INSERT INTO cars ($cols) VALUES ($ph)")->execute($data);
    }
    header('Location: cars.php'); exit;
}

$pageTitle = $id?'Edito Makinë':'Shto Makinë'; $active='cars';
include '_layout.php';
?>
<h1><?= $pageTitle ?></h1>
<form method="post" enctype="multipart/form-data" style="background:#fff;padding:24px;border-radius:12px;margin-top:18px;max-width:800px">
  <div class="form-row">
    <div><label>Marka</label><input name="brand" required value="<?= htmlspecialchars($car['brand']) ?>"></div>
    <div><label>Modeli</label><input name="model" required value="<?= htmlspecialchars($car['model']) ?>"></div>
  </div>
  <div class="form-row">
    <div><label>Viti</label><input type="number" name="year" required value="<?= $car['year'] ?>"></div>
    <div><label>Çmimi/ditë (€)</label><input type="number" step="0.01" name="price_per_day" required value="<?= $car['price_per_day'] ?>"></div>
  </div>
  <div class="form-row">
    <div><label>Kambio</label>
      <select name="transmission"><?php foreach(['Manual','Automatik'] as $t): ?><option <?= $car['transmission']===$t?'selected':'' ?>><?= $t ?></option><?php endforeach; ?></select>
    </div>
    <div><label>Karburant</label>
      <select name="fuel"><?php foreach(['Benzine','Naft','Hybrid','Elektrik'] as $f): ?><option <?= $car['fuel']===$f?'selected':'' ?>><?= $f ?></option><?php endforeach; ?></select>
    </div>
  </div>
  <div class="form-row">
    <div><label>Vende</label><input type="number" name="seats" value="<?= $car['seats'] ?>"></div>
    <div><label>Foto (opsionale)</label><input type="file" name="image" accept="image/*"></div>
  </div>
  <div class="form-row full"><div><label>Përshkrimi</label><textarea name="description" rows="3"><?= htmlspecialchars($car['description']) ?></textarea></div></div>
  <label><input type="checkbox" name="available" <?= $car['available']?'checked':'' ?>> Disponibël</label>
  <div style="margin-top:18px"><button class="btn">Ruaj</button> <a class="btn btn-secondary" href="cars.php">Anullo</a></div>
</form>
<?php include '_layout_end.php'; ?>