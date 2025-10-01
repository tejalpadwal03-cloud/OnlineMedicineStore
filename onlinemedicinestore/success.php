<?php
ob_start();
session_start();
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Clear the cart after successful payment
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .success-section {
            background-image: url('images/banner3.jpg'); /* Replace with your background image */
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .success-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h2 {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .home-btn {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .home-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<section class="success-section">
    <div class="success-container">
        <h2>Payment Successful!</h2>
        <p>Thank you for your purchase. Your order has been placed successfully.</p>
        <a href="index.php" class="home-btn">Return to Home</a>
    </div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
