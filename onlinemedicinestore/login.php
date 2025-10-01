<?php
ob_start();
session_start();
include 'config.php';
include 'header.php'; 

// ✅ Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found.";
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Medicine Store</title>
    <link rel="stylesheet" href="styles.css"> <!-- ✅ Link to external CSS -->
    <style>
    /* ✅ Background Image */
    .login-section {
        background: url('images/banner3.jpg') no-repeat center center/cover;
        height: 60vh; /* Full viewport height */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* ✅ Login Box */
    .login-container {
        background: rgba(255, 255, 255, 0.95); /* Semi-transparent */
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 350px;
        text-align: center;
    }

    /* ✅ Input Fields */
    .login-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* ✅ Login Button */
    .login-container button {
        width: 100%;
        padding: 10px;
        background: darkblue;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .login-container button:hover {
        background: navy;
    }

    /* ✅ Links */
    .login-container a {
        display: block;
        margin-top: 10px;
        text-decoration: none;
        color: darkblue;
    }

    /* ✅ Error Message */
    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 10px;
    }
    </style>
</head>
<body>

<div class="login-section">
    <div class="login-container">
        <h2>Login</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?> <!-- ✅ Show error message -->

        <form method="POST">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>

        <a href="register.php">Don't have an account? Register Here</a>
        <a href="forgot_password.php">Forgot Password?</a>
    </div>
</div>

<?php include 'footer.php'; ?> <!-- ✅ Footer is included properly -->

</body>
</html>
