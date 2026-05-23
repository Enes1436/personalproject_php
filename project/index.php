<?php
include 'config.php';

$sql = "SELECT * FROM cars ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent A Car - Available Cars</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>🚗 Rent A Car</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Available Cars</h2>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="car-list">
                <?php while($car = mysqli_fetch_assoc($result)): ?>
                <div class="car-card">
                    <h3><?php echo htmlspecialchars($car['model']); ?></h3>
                    <?php if($car['car_name']): ?>
                        <p><strong>Model:</strong> <?php echo htmlspecialchars($car['car_name']); ?></p>
                    <?php endif; ?>
                    <?php if($car['description']): ?>
                        <p><?php echo htmlspecialchars($car['description']); ?></p>
                    <?php endif; ?>
                    
                    <div class="car-info">
                        <div class="info-item">
                            <strong>Price</strong>
                            €<?php echo htmlspecialchars($car['price_per_day']); ?>/day
                        </div>
                        <?php if($car['available']): ?>
                            <div class="info-item" style="background:#d4edda;">
                                <strong>Status</strong>
                                Available
                            </div>
                        <?php else: ?>
                            <div class="info-item" style="background:#f8d7da;">
                                <strong>Status</strong>
                                Unavailable
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($car['available']): ?>
                        <a href="form.php?car_id=<?php echo $car['id']; ?>" class="btn">Reserve Now</a>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p style="text-align:center; color:#666; padding:40px;">No cars available at the moment.</p>
        <?php endif; ?>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> Rent A Car System. All rights reserved.
    </footer>
</div>
</body>
</html>