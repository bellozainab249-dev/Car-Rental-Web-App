<?php
session_start();
require_once 'db_connect.php';

// SECURITY CHECK: If they are not logged in, OR they are not an Admin, kick them back to login!
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: login.php");
    exit();
}

// Fetch all vehicles from the database to display on the dashboard
try {
    $query = "SELECT v.Vehicle_ID, v.Make, v.Model, v.Year, v.Category, v.Current_Status, b.Branch_Name 
              FROM Vehicles v 
              LEFT JOIN Branches b ON v.Current_Branch_ID = b.Branch_ID
              ORDER BY v.Vehicle_ID ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching fleet data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lone Star Rides</title>
    <style>
        /* Phase 1 Branding: Deep Navy Blue & Dusty Gold */
        body { font-family: sans-serif; background-color: #1a202c; color: #ffffff; margin: 0; }
        header { background-color: #0f172a; padding: 20px; text-align: center; border-bottom: 3px solid #d4af37; }
        h1, h2 { color: #d4af37; }
        .container { max-width: 1000px; margin: 30px auto; padding: 20px; background-color: #2d3748; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #4a5568; }
        th { background-color: #0f172a; color: #d4af37; }
        .logout-btn { display: inline-block; padding: 10px 15px; background-color: #ff6b6b; color: white; text-decoration: none; border-radius: 4px; float: right; margin-top: -40px; }
        .logout-btn:hover { background-color: #ff4c4c; }
    </style>
</head>
<body>

    <header>
        <h1>Lone Star Rides - Admin Panel</h1>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['first_name']); ?></p>
        <a href="logout.php" class="logout-btn">Log Out</a>
    </header>

    <div class="container">
        <h2>Current Fleet Status</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vehicle</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($vehicles) > 0): ?>
                    <?php foreach ($vehicles as $car): ?>
                        <tr>
                            <td>#<?php echo $car['Vehicle_ID']; ?></td>
                            <td><?php echo $car['Year'] . ' ' . htmlspecialchars($car['Make'] . ' ' . $car['Model']); ?></td>
                            <td><?php echo htmlspecialchars($car['Category']); ?></td>
                            <td><?php echo htmlspecialchars($car['Branch_Name'] ?? 'Unassigned'); ?></td>
                            <td><?php echo htmlspecialchars($car['Current_Status']); ?></td>
                            <td><a href="#" style="color: #d4af37;">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No vehicles found in the fleet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>