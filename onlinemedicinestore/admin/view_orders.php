<?php
include("config.php");

$query = "SELECT id, user_id, amount, status FROM orders";
$result = mysqli_query($conn, $query);

// Check for SQL errors
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Dark Green Navigation Bar */
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
        .orders-section {
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

        /* Table Styling */
        .table-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 80%;
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                text-align: center;
            }
            nav ul li {
                margin: 10px 0;
            }
            .table-container {
                width: 95%;
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

<!-- Orders Section -->
<section class="orders-section">
    <h2>View Orders</h2>
    
    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']); ?></td>
                    <td><?= htmlspecialchars($order['user_id']); ?></td>
                    <td><?= htmlspecialchars($order['amount']); ?></td>
                    <td><?= htmlspecialchars($order['status']); ?></td>
                </tr>
            <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No orders found</td></tr>
            <?php endif; ?>
        </table>
    </div>
</section>

<?php
// Free result and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>

<?php include 'footer.php'; ?>

</body>
</html>
