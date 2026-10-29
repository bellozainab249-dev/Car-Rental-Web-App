<?php
// 1. Start the session so we can access it
session_start();

// 2. Clear all session variables
$_SESSION = array();

// 3. Destroy the session entirely
session_destroy();

// 4. THIS IS THE MISSING PIECE: Redirect to the home page
header("Location: index.php");
exit();
?>