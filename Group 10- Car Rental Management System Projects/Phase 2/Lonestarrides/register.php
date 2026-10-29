<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $_POST['first_name'];
    $last  = $_POST['last_name'];
    $email = $_POST['email'];
    // Using password_hash for security
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    try {
        // MATCHED TO YOUR SCREENSHOT: Password_Hash instead of Password
        $sql = "INSERT INTO Users (First_Name, Last_Name, Email, Password_Hash, Role) 
                VALUES (?, ?, ?, ?, 'Customer')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$first, $last, $email, $pass]);
        
        // Success! Redirect to login
        header("Location: login.php?msg=success");
        exit();

    } catch(PDOException $e) {
        // This will tell us exactly why it fails if it happens again
        die("Database Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Lone Star Rides</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: sans-serif; background: #1a202c; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .reg-card { background: white; color: #333; padding: 40px; border-radius: 12px; width: 400px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        h2 { color: #1a202c; text-align: center; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background: #d4af37; color: #1a202c; border: none; padding: 14px; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px; margin-top: 10px; }
        button:hover { background: #b8962d; }
        .login-link { text-align: center; margin-top: 15px; font-size: 14px; }
        .login-link a { color: #d4af37; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="reg-card">
        <h2>Join Lone Star Rides</h2>
        <form method="POST">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <button type="submit">Create Account</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>