<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "<p class='success'>A password reset link has been sent to your email.</p>";
        // In real-world applications, send an email with a reset link
    } else {
        echo "<p class='error'>Email not found!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Online Medicine Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="forgot-container">
    <h2>Forgot Password</h2>
    <form method="POST">
        <input type="email" name="email" required placeholder="Enter your email">
        <button type="submit">Reset Password</button>
    </form>
    <a href="login.php">Back to Login</a>
</div>

</body>
</html>
