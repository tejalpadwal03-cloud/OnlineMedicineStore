<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
// include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        /* Dashboard Background Section */
        .dashboard-section {
            background: url('../images/banner3.jpg') no-repeat center center/cover;
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 100px 20px 20px; /* Prevents navbar overlap */
        }

        h1 {
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
        }

        .dashboard-content {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin-top: 20px;
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

<!-- Dashboard Section -->
<section class="dashboard-section">
    <h1>Welcome, Admin!</h1>
    <!--<div class="dashboard-content">
        <p>Use the navigation above to manage the store.</p>
    </div>-->
</section>

<?php include 'footer.php'; ?>

</body>
</html>
