<?php
session_start();
include ('config.php');
// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Add Medicine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_medicine'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $manufacture_date = $_POST['manufacture_date'];
    $expiry_date = $_POST['expiry_date'];
    
    // Upload image
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);
    
    //if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO medicines (name, category, price, stock, manufacture_date, expiry_date, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdisss", $name, $category, $price, $stock, $manufacture_date, $expiry_date, $image);
        $stmt->execute();
        header("Location: manage_products.php");
        exit();
    }

// Delete Medicine
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM medicines WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_products.php");
    exit();
}

// Fetch medicines
$result = $conn->query("SELECT * FROM medicines");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .section {
            background: url('../images/banner3.jpg') no-repeat center center/cover;
            padding: 20px;
            min-height: 100vh;
        }
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
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        h2 {
            margin-bottom: 20px;
            color: #004d40;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        input, select, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #004d40;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #00796b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #00796b;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .edit-btn, .delete-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.3s;
            color: white;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #0277bd;
        }
        .edit-btn:hover {
            background-color: #01579b;
        }
        .delete-btn {
            background-color: #d32f2f;
        }
        .delete-btn:hover {
            background-color: #b71c1c;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .footer {
            background-color: #004d40;
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="nav">
    <a href="manage_products.php">Manage Products</a>
    <a href="manage_orders.php">Manage Orders</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="view_orders.php">View Orders</a>
    <a href="logout.php">Logout</a>
</div>

<div class="section">
    <div class="container">
        <h2>Manage Medicines</h2>
        <!-- Add Medicine Form -->
        <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" required placeholder="Medicine Name">
    <input type="text" name="category" required placeholder="Category">
    <input type="number" step="0.01" name="price" required placeholder="Price">
    <input type="number" name="stock" required placeholder="Stock">
    
    <!-- Use label instead of placeholder for date fields -->
    <label for="manufacture_date">Manufacture Date:</label>
    <input type="date" id="manufacture_date" name="manufacture_date" required>
    
    <label for="expiry_date">Expiry Date:</label>
    <input type="date" id="expiry_date" name="expiry_date" required>
    
    <input type="file" name="image" required>
    <button type="submit" name="add_medicine">Add Medicine</button>
</form>


        <!-- Medicine Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Manufacture Date</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['category']; ?></td>
                <td>₹<?= number_format($row['price'], 2); ?></td>
                <td><?= $row['stock']; ?></td>
                <td><?= $row['manufacture_date']; ?></td>
                <td><?= $row['expiry_date']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                    <a href="?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<div class="footer">
    © 2025 Online Medicine Store | Admin Panel
</div>

</body>
</html>
