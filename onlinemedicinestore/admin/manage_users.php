<?php
include 'config.php';

// Fetch users from the database
$query = "SELECT id, name, email FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
        /* Table Header & Content Colors */
        th {
            background: #004d40; /* Dark Green Header */
            color: white;
        }
        tr:nth-child(even) {
            background: #e0f2f1; /* Light Green Row */
        }
        tr:nth-child(odd) {
            background: #ffffff; /* White Row */
        }
        tr:hover {
            background: #c8e6c9; /* Highlight Effect */
        }
        .btn-edit, .btn-delete {
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-edit {
            background: #007bff;
            color: white;
        }
        .btn-edit:hover {
            background: #0056b3;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background: #a71d2a;
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

<!-- Navigation Bar -->
<div class="nav">
    
    <a href="manage_products.php">Manage Products</a>
    <a href="manage_orders.php">Manage Orders</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
</div>

<section>
    <div class="container">
        <h2>Manage Users</h2>
         <!--<a href="admin_dashboard.php" class="btn-back">Back to Dashboard</a>-->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="delete_user.php?id=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>
<?php include 'footer.php' ?>
</body>
</html>
