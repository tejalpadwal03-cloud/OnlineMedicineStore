<?php
session_start();
include 'config.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='index.php'>Go back to shopping</a></p>";
    exit();
}

// Simulate order placement (In real app, save to database)
echo "<h2>Order Confirmed</h2>";
echo "<p>Thank you for your purchase! Your order has been placed successfully.</p>";

// Clear the cart after order confirmation
unset($_SESSION['cart']);

echo "<a href='index.php'>Continue Shopping</a>";
?>
