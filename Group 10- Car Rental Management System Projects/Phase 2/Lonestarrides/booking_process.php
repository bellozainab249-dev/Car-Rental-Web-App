<?php
session_start();
require_once 'db_connect.php';

// Security check: Must be logged in to book
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get data from the URL (passed from vehicles.php)
$v_id   = $_GET['v_id'] ?? null;
$p_id   = $_GET['p_id'] ?? null;
$d_id   = (!empty($_GET['d_id'])) ? $_GET['d_id'] : $p_id; // Fallback for Same Location
$start  = $_GET['start'] ?? null;
$end    = $_GET['end'] ?? null;

try {
    $pdo->beginTransaction();

    // 1. Fetch vehicle daily rate to calculate total cost
    $stmt = $pdo->prepare("SELECT Daily_Rate FROM Vehicles WHERE Vehicle_ID = ?");
    $stmt->execute([$v_id]);
    $rate = $stmt->fetchColumn();

    $days = (strtotime($end) - strtotime($start)) / (60 * 60 * 24);
    $total_cost = ($days > 0 ? $days : 1) * $rate;

    // 2. Insert into the correct table: Reservations
    $sql = "INSERT INTO Reservations (User_ID, Vehicle_ID, Pickup_Branch_ID, Dropoff_Branch_ID, Pickup_Date, Dropoff_Date, Total_Cost, Booking_Status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Active')";
    $pdo->prepare($sql)->execute([$_SESSION['user_id'], $v_id, $p_id, $d_id, $start, $end, $total_cost]);

    // 3. Update Vehicle status so it's no longer 'Available'
    $pdo->prepare("UPDATE Vehicles SET Current_Status = 'Rented' WHERE Vehicle_ID = ?")->execute([$v_id]);

    $pdo->commit();
    echo "Booking Successful! Redirecting to your dashboard...";
    header("Refresh: 2; URL=customer_dashboard.php");

} catch (Exception $e) {
    $pdo->rollBack();
    die("Booking failed: " . $e->getMessage());
}
?>