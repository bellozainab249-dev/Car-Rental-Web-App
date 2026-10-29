<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's reservations joining with Vehicle and Branch info
$stmt = $pdo->prepare("
    SELECT r.*, v.Make, v.Model, b.Branch_Name 
    FROM Reservations r
    JOIN Vehicles v ON r.Vehicle_ID = v.Vehicle_ID
    JOIN Branches b ON r.Pickup_Branch_ID = b.Branch_ID
    WHERE r.User_ID = ?
    ORDER BY r.Pickup_Date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Dashboard - Lone Star Rides</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background-color: #1a202c; color: white; padding: 40px; font-family: sans-serif; }
        .card { background: #2d3748; padding: 20px; border-radius: 8px; border-left: 5px solid #d4af37; margin-bottom: 15px; }
        .status-active { color: #6bff9e; font-weight: bold; }
        h1 { color: #d4af37; }
    </style>
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Welcome, <?php echo $_SESSION['first_name']; ?></h1>
        <a href="logout.php" style="color: #ff6b6b; text-decoration: none; font-weight: bold;">Logout</a>
    </header>

    <h2>Your Current & Past Bookings</h2>
    <?php if (empty($bookings)): ?>
        <p>You haven't made any reservations yet. <a href="index.php" style="color:#d4af37;">Book a car now!</a></p>
    <?php else: ?>
        <?php foreach ($bookings as $b): ?>
            <div class="card">
                <div style="display: flex; justify-content: space-between;">
                    <h3><?php echo $b['Make'] . " " . $b['Model']; ?></h3>
                    <span class="status-active"><?php echo $b['Booking_Status']; ?></span>
                </div>
                <p>Location: <?php echo $b['Branch_Name']; ?></p>
                <p>Dates: <?php echo date('M d', strtotime($b['Pickup_Date'])); ?> - <?php echo date('M d', strtotime($b['Dropoff_Date'])); ?></p>
                <p style="font-weight: bold; color: #d4af37;">Total: $<?php echo number_format($b['Total_Cost'], 2); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <br><a href="index.php" style="color: #d4af37;">← Back to Search</a>
</body>
</html>