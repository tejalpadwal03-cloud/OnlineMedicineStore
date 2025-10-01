<?php
session_start();
include ('config.php');

if (!isset($_SESSION['admin_id'])) {
    die("Access Denied.");
}

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$order_id = intval($_GET['id']);

$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Order not found.");
}

$order = $result->fetch_assoc();
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
            font-family: Arial, sans-serif;
        }

        /* Dark Green Navbar */
        nav {
            background: #004d40; /* Dark Green */
            padding: 15px 0;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            transition: background 0.3s ease-in-out;
        }

        nav ul li a:hover {
            background: #00796b; /* Lighter Green on Hover */
        }

        /* Background Section */
        .update-section {
            background: url('../images/banner3.jpg') no-repeat center center/cover;
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 100px 20px 20px;
        }

        h2 {
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
        }

        /* Form Container */
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 50%;
            margin-top: 20px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 18px;
            margin-bottom: 10px;
        }

        select {
            padding: 8px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        button {
            background: #004d40;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #00796b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <ul>
        <li><a href="manage_products.php">Manage Products</a></li>
        <li><a href="manage_orders.php">Manage Orders</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="view_orders.php">View Orders</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Update Order Section -->
<section class="update-section">
    <h2>Update Order</h2>

    <div class="form-container">
        <form method="post" action="update_order_process.php">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Pending" <?= ($order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Shipped" <?= ($order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                <option value="Delivered" <?= ($order['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?= ($order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <button type="submit">Update Order</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
