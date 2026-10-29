<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['Password_Hash'])) {
        $_SESSION['user_id'] = $user['User_ID'];
        $_SESSION['first_name'] = $user['First_Name'];
        $_SESSION['role'] = $user['Role'];

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Lone Star Rides</title>
    <style>
        body { font-family: sans-serif; background: #1a202c; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; color: #333; padding: 40px; border-radius: 8px; width: 350px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background: #d4af37; border: none; padding: 12px; font-weight: bold; cursor: pointer; border-radius: 4px; color: #1a202c; }
        button:hover { background: #b8962d; }
        .error-msg { color: red; margin-bottom: 10px; font-size: 14px; }
        .footer-links { margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px; }
        .footer-links a { color: #d4af37; text-decoration: none; font-weight: bold; font-size: 14px; display: block; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>
        
        <?php if ($error): ?>
            <p class="error-msg"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="footer-links">
            <a href="register.php">Create an account</a>
            <a href="index.php" style="color: #666; font-weight: normal;">← Back to Search</a>
        </div>
    </div>
</body>
</html>