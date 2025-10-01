<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM medicines WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Medicine not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_stock = $_POST['stock'];

    $update_query = "UPDATE medicines SET stock = '$new_stock' WHERE id = $id";
    
    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Stock updated successfully!'); window.location='manage_products.php';</script>";
        exit;
    } else {
        echo "Error updating stock: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        /* Background Section */
        section {
            width: 100%;
            height: 100vh;
            background: url('../images/banner3.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 15px;
            color: #333;
        }
        label {
            font-size: 16px;
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        input:disabled {
            background-color: #e9ecef;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            width: 48%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-update {
            background-color: #28a745;
            color: white;
        }
        .btn-update:hover {
            background-color: #218838;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            text-align: center;
            display: block;
            line-height: 40px;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <section>
        <div class="container">
            <h2>Edit Medicine Stock</h2>
            <form method="POST">
                <label>Medicine Name:</label>
                <input type="text" value="<?= $row['name']; ?>" disabled>

                <label>Stock:</label>
                <input type="number" name="stock" value="<?= $row['stock']; ?>" required>

                <div class="btn-container">
                    <button type="submit" class="btn btn-update">Update</button>
                    <a href="manage_products.php" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </section>

</body>
</html>
