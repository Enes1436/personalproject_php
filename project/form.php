<?php
include 'config.php';
include 'functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_car'])) {

    $car_name = clean($_POST['car_name']);
    $model = clean($_POST['model']);
    $price = clean($_POST['price']);
    $description = clean($_POST['description'] ?? '');

    if (empty($car_name) || empty($model) || empty($price)) {
        $message = "All fields are required!";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO cars(car_name, model, price_per_day, description, available) VALUES(?, ?, ?, ?, 1)");
        mysqli_stmt_bind_param($stmt, "ssds", $car_name, $model, $price, $description);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Car added successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car - Rent A Car</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>➕ Add New Car</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Add a New Car</h2>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="max-width: 600px;">
            <div class="form-group">
                <label for="car_name">Car Name</label>
                <input type="text" id="car_name" name="car_name" placeholder="e.g., Toyota Camry" required>
            </div>

            <div class="form-group">
                <label for="model">Model / Year</label>
                <input type="text" id="model" name="model" placeholder="e.g., 2023" required>
            </div>

            <div class="form-group">
                <label for="price">Price Per Day (€)</label>
                <input type="number" id="price" step="0.01" name="price" placeholder="50.00" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Add car details, features, etc."></textarea>
            </div>

            <button type="submit" name="add_car">Add Car</button>
        </form>

        <br>
        <a href="dashboard.php" class="btn" style="background: #666;">Back to Dashboard</a>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> Rent A Car System. All rights reserved.
    </footer>
</div>
</body>
</html>