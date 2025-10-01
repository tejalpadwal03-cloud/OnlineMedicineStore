<?php
//session_start();
include 'config.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
    header("Location: manage_products.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form method="POST">
        <input type="text" name="name" required placeholder="Product Name">
        <input type="number" step="0.01" name="price" required placeholder="Price">
        <button type="submit">Add</button>
    </form>
</body>
</html>
