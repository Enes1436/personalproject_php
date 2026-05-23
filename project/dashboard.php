<?php
include 'config.php';
include 'functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Get cars list
$cars_result = mysqli_query($conn, "SELECT * FROM cars ORDER BY id DESC");
$cars = mysqli_fetch_all($cars_result, MYSQLI_ASSOC);

// Get reservations
$res_result = mysqli_query($conn, "SELECT * FROM cars");
$reservations = mysqli_fetch_all($res_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>🎯 Admin Dashboard</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="form.php?action=car">Add New Car</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Welcome <?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
        
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div style="text-align: center;">
                <div style="font-size: 2em; font-weight: bold;"><?php echo count($cars); ?></div>
                <div>Total Cars</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2em; font-weight: bold;"><?php echo count(array_filter($cars, fn($c) => $c['available'])); ?></div>
                <div>Available Cars</div>
            </div>
        </div>

        <h3>Manage Cars</h3>
        <?php if (count($cars) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Car Name</th>
                        <th>Price/Day</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($car['model']); ?></td>
                        <td><?php echo htmlspecialchars($car['car_name'] ?? '-'); ?></td>
                        <td>€<?php echo htmlspecialchars($car['price_per_day']); ?></td>
                        <td>
                            <?php if ($car['available']): ?>
                                <span style="color: green; font-weight: bold;">✓ Available</span>
                            <?php else: ?>
                                <span style="color: red; font-weight: bold;">✗ Unavailable</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="form.php?action=car&car_id=<?php echo $car['id']; ?>" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #666;">No cars added yet.</p>
        <?php endif; ?>

        <br><br>
        <a href="index.php" class="btn">View All Cars</a>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> Rent A Car System. All rights reserved.
    </footer>
</div>
</body>
</html>