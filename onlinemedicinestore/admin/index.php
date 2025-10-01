<?php
session_start(); // Start the session

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to admin login page if not logged in
    header("Location: admin_login.php");
    exit();
}

// Redirect to the admin dashboard
header("Location: admin_dashboard.php");
exit();
?>
