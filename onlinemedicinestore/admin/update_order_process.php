<?php
session_start();
include ('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Access Denied.");
}

// Validate POST request
if (!isset($_POST['order_id'], $_POST['status'])) {
    die("Invalid request.");
}

$order_id = intval($_POST['order_id']);
$status = $_POST['status'];

// Fix: Ensure correct column name
$sql = "UPDATE orders SET status = ? WHERE id = ?"; // Change `id` if needed
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database Error: " . $conn->error);
}

$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Order updated successfully!";
    header("Location: manage_orders.php"); // Redirect after update
    exit();
} else {
    die("Database Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar */
        nav {
            background: darkgreen;
            padding: 15px 0;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Background */
        .order-section {
            background: url('../images/banner3.jpg') no-repeat center center/cover;
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 100px 20px 20px;
        }

        h1 {
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
        }

        .order-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin-top: 20px;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
        }

        select {
            background: white;
        }

        button {
            background: darkgreen;
            color: white;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        button:hover {
            background: green;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <ul>
        <li><a href="manage_products.php">Manage Products</a></li>
        <li><a href="manage_orders.php">Manage Orders</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="view_orders.php">View Orders</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Order Update Section -->
<section class="order-section">
    <h1>Update Order</h1>
    
    <div class="order-form">
        <form method="post" action="update_order_process.php">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id); ?>">
            
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Pending" <?= ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Shipped" <?= ($status == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                <option value="Delivered" <?= ($status == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?= ($status == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <button type="submit">Update Order</button>
        </form>
    </div>
</section>

</body>
</html>
