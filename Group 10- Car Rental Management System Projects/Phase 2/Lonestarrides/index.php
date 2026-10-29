<?php
session_start();
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lone Star Rides - Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="main-nav">
    <div class="logo">
        <img src="images/logo.png" alt="Lone Star Rides Logo" style="height:100px;">
    </div>
    <nav>
        <a href="index.php">Book a car</a>
        <a href="customer_dashboard.php">Manage</a>
        <a href="locations.php">Locations</a>
        <a href="about.php">About Us</a>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <span style="color:#d4af37; margin-left:20px;">Hello, <?php echo $_SESSION['first_name']; ?></span>
            <a href="logout.php" class="btn-login" style="border-color:#ff6b6b; color:#ff6b6b;">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </nav>
</header>


<section class="hero">
    <div class="booking-container">
        <div class="booking-tabs">
        </div>
        <div class="booking-form">
            <h2>Book your Lone Star rental</h2>

            <form action="vehicles.php" method="GET">

            

                
                <div class="input-group">
                    <label>Pickup Location</label>
                    <select name="pickup_branch" required style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="1">Houston HQ</option>
                        <option value="2">Dallas Hub</option>
                    </select>
                </div>

                <div class="checkbox-group" style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px; cursor: pointer; color: #333; font-size: 14px;">
                    <input type="checkbox" id="sameLocation" name="same_location" checked style="width: 18px; height: 18px; accent-color: #d4af37;">
                    <label for="sameLocation">Same Drop-Off Location</label>
                </div>

                <div id="dropoffGroup" class="input-group" style="display: none;">
                    <label>Drop-Off Location</label>
                    <select name="dropoff_branch" style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Select return location...</option>
                        <option value="1">Houston HQ</option>
                        <option value="2">Dallas Hub</option>
                    </select>
                </div>

                <div class="date-row">
                    <div class="input-group">
                        <label>Pickup Details</label>
                        <input type="date" id="p_date" name="pickup_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="input-group">
                        <label>Drop-Off Details</label>
                        <input type="date" id="r_date" name="return_date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                
                <button type="submit" class="view-btn">View vehicles</button>
            </form>
        </div>
    </div>
</section>

<script src="js/script.js"></script>

</body>
</html>