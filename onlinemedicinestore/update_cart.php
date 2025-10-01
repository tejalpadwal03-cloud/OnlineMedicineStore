<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_id = $_POST['medicine_id'];
    $new_quantity = intval($_POST['quantity']);

    // Ensure the item exists in the cart
    if (isset($_SESSION['cart'][$medicine_id])) {
        if ($new_quantity > 0) {
            $_SESSION['cart'][$medicine_id] = $new_quantity; // Update quantity
        } else {
            unset($_SESSION['cart'][$medicine_id]); // Remove item if quantity is 0
        }
    }

    // Redirect back to checkout page
    header("Location: checkout.php");
    exit();
}
?>
