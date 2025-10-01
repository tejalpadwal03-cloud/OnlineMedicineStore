<?php
include 'config.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email is already registered
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        $message = "<p class='error'>Email already registered!</p>";
    } else {
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($query)) {
            $message = "<p class='success'>Registration successful! <a href='login.php'>Login here</a></p>";
        } else {
            $message = "<p class='error'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Medicine Store</title>
    <style>
        /* ✅ Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* ✅ Page Layout Fix */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* ✅ Main Content */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('images/banner3.jpg') no-repeat center center/cover;
            padding: 20px;
        }

        /* ✅ Registration Container */
        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        h2 {
            color: #2E8B57;
            margin-bottom: 20px;
        }

        /* ✅ Form Styling */
        form {
            display: flex;
            flex-direction: column;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
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

        /* ✅ Link Styling */
        a {
            display: block;
            margin-top: 10px;
            color: #2E8B57;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* ✅ Error and Success Messages */
        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        /* ✅ Footer Fix */
        .footer {
            background: #2E8B57;
            color: white;
            text-align: center;
            padding: 15px;
            width: 100%;
            position: relative;
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- ✅ Main Content (Ensures Footer Stays at Bottom) -->
<div class="main-content">
    <div class="register-container">
        <h2>Register</h2>
        <?php if (isset($message)) echo $message; ?>
        <form method="POST">
            <input type="text" name="name" required placeholder="Full Name">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Register</button>
        </form>
        <a href="login.php">Already have an account? Login Here</a>
    </div>
</div>

<!-- ✅ Footer (Always Sticks to Bottom) -->
<?php include 'footer.php'; ?>

</body>
</html>
