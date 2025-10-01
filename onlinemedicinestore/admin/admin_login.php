<?php 
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = $conn->real_escape_string($username);

    $query = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if ($password === $user['password']) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $message = "<p class='error'>Incorrect password.</p>";
            }
        } else {
            $message = "<p class='error'>No account found.</p>";
        }
    } else {
        $message = "<p class='error'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-section {
            /*background: url('../images/banner3.jpg') no-repeat center center/cover;*/
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh; /* Full screen height */
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        h2 {
            color: #2E8B57;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background: #2E8B57;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background: #1C6E43;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-section">
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($message)) echo $message; ?>
        <form method="POST">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>
</div>


</body>
</html>
