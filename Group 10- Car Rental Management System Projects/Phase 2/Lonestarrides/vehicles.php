<?php
session_start();
require_once 'db_connect.php';

// 1. Get search parameters from the URL (passed from index.php)
$pickup_branch = $_GET['pickup_branch'] ?? 1;
$pickup_date   = $_GET['pickup_date'] ?? '';
$return_date   = $_GET['return_date'] ?? '';
$dropoff_branch = !empty($_GET['dropoff_branch']) ? $_GET['dropoff_branch'] : $pickup_branch;

// Convert strings to date objects for comparison
$p_date = strtotime($pickup_date);
$r_date = strtotime($return_date);
$today = strtotime(date('Y-m-d'));

if ($p_date < $today) {
    die("Error: Pickup date cannot be in the past.");
}

if ($r_date <= $p_date) {
    die("Error: Return date must be after the pickup date.");
}

// 2. Fetch vehicles using the consolidated lonestarrides_db
try {
    $stmt = $pdo->prepare("SELECT * FROM Vehicles WHERE Current_Branch_ID = :branch AND Current_Status = 'Available'");
    $stmt->execute([':branch' => $pickup_branch]);
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error loading vehicles: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Vehicles - Lone Star Rides</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: sans-serif; background-color: #1a202c; color: white; padding: 20px; }
        .vehicle-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .vehicle-card { background: #2d3748; padding: 20px; border-radius: 8px; border: 1px solid #d4af37; }
        .btn-book { background: #d4af37; color: #1a202c; padding: 10px; display: block; text-align: center; text-decoration: none; font-weight: bold; border-radius: 4px; margin-top: 10px; }
        h2 { color: #d4af37; border-bottom: 2px solid #d4af37; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Available Vehicles at Branch #<?php echo htmlspecialchars($pickup_branch); ?></h2>
    
    <div class="vehicle-grid">
        <?php if (empty($vehicles)): ?>
            <p>No vehicles are currently available at this location. Please try another branch.</p>
        <?php else: ?>
            <?php foreach ($vehicles as $car): ?>
                <div class="vehicle-card">
                    <h3><?php echo htmlspecialchars($car['Year'] . " " . $car['Make'] . " " . $car['Model']); ?></h3>
                    <p>Category: <?php echo htmlspecialchars($car['Category']); ?> | Fuel: <?php echo htmlspecialchars($car['Fuel_Type']); ?></p>
                    <p style="color: #d4af37; font-size: 1.2em; font-weight: bold;">$<?php echo number_format($car['Daily_Rate'], 2); ?> / day</p>
                    
                    <a href="booking_process.php?v_id=<?php echo $car['Vehicle_ID']; ?>&p_id=<?php echo $pickup_branch; ?>&d_id=<?php echo $dropoff_branch; ?>&start=<?php echo $pickup_date; ?>&end=<?php echo $return_date; ?>" class="btn-book">Book Now</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <p style="margin-top: 30px;"><a href="index.php" style="color: #d4af37; text-decoration: none;">← Change Search Criteria</a></p>
</body>
</html>