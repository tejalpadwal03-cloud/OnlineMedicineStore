<?php
session_start();
include ('config.php');

// Check if database connection is set
if (!isset($conn)) {
    die("Database connection is not set.");
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// ✅ Handle clearing all orders
if (isset($_POST['clear_orders'])) {
    $conn->begin_transaction();
    try {
        // Delete all order items first (to avoid foreign key issues)
        $conn->query("DELETE FROM order_items");
        // Delete all orders
        $conn->query("DELETE FROM orders");

        $conn->commit();
        echo "<script>alert('All orders have been cleared successfully!'); window.location.href='manage_orders.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Failed to clear orders: " . $e->getMessage() . "');</script>";
    }
}

// ✅ Fetch orders from the database
$sql = "SELECT id, user_id, amount, status FROM orders";
$result = $conn->query($sql);

// Check for SQL errors
if (!$result) {
    die("SQL Error: " . $conn->error . "<br>Query: " . $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
        }
        /* Navigation Bar */
        .nav {
            background: #004d40;
            padding: 15px;
            text-align: center;
        }
        .nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin: 0 15px;
            padding: 10px;
            font-weight: bold;
        }
        .nav a:hover {
            background: #00796b;
            border-radius: 5px;
        }
        /* Background Section */
        section {
            width: 100%;
            min-height: 60vh;
            background: url('../images/banner3.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 900px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .btn-back, .btn-clear {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-back {
            background: #007bff;
            color: white;
        }
        .btn-back:hover {
            background: #0056b3;
        }
        .btn-clear {
            background: #dc3545;
            color: white;
            margin-left: 10px;
        }
        .btn-clear:hover {
            background: #c82333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        /* Updated Table Header & Content Colors */
        th {
            background: #004d40;
            color: white;
        }
        tr:nth-child(even) {
            background: #e0f2f1;
        }
        tr:nth-child(odd) {
            background: #ffffff;
        }
        tr:hover {
            background: #c8e6c9;
        }
        .btn-update {
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            background: #28a745;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-update:hover {
            background: #218838;
        }
        @media (max-width: 600px) {
            .container {
                width: 95%;
            }
            table {
                font-size: 14px;
            }
            .nav a {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>

<!-- ✅ Navigation Bar -->
<div class="nav">
    <a href="manage_products.php">Manage Products</a>
    <a href="manage_orders.php">Manage Orders</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
</div>

<section>
    <div class="container">
        <h2>Manage Orders</h2>
        <!--<a href="admin_dashboard.php" class="btn-back">Back to Dashboard</a>-->

        <!-- ✅ Clear Orders Form -->
        <form method="post" style="display:inline;">
            <button type="submit" name="clear_orders" class="btn-clear" onclick="return confirm('Are you sure you want to delete all orders?');">
                Clear All Orders
            </button>
        </form>

        <!-- ✅ Orders Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['user_id']); ?></td>
                        <td><?= isset($row['amount']) ? htmlspecialchars($row['amount']) : 'N/A'; ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td>
                            <a href="update_order.php?id=<?= $row['id']; ?>" class="btn-update">Update</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No orders found</td></tr>
            <?php endif; ?>
        </table>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
