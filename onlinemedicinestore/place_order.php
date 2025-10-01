<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    if ($payment_method == "COD") {
        $status = "Pending (COD)";
    } else {
        $status = "Pending (Online Payment)";
        header("Location: payment.php"); // Redirect to payment gateway if online payment is selected
        exit();
    }

    // Insert order into database
    $query = "INSERT INTO orders (user_id, address, amount, payment_method, status) 
              VALUES ('$user_id', '$address', '$amount', '$payment_method', '$status')";
    if ($conn->query($query)) {
        echo "<h3>Order placed successfully!</h3>";
        echo "<p>Payment Method: $payment_method</p>";
        echo "<p>Your order will be delivered soon.</p>";
        unset($_SESSION['cart']); // Clear cart after order is placed
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
