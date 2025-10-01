<?php
include 'config.php';

// Get user ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
}

// Update user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    
    if ($conn->query($updateQuery) === TRUE) {
        header("Location: manage_users.php"); // Redirect to manage users page
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
        .edit-user-section {
           /* background: url('../images/banner3.jpg') no-repeat center center/cover;*/
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

        /* Form Styling */
        .edit-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 50%;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #004d40; /* Dark Green */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #00796b; /* Lighter Green */
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
            .edit-form {
                width: 80%;
            }
        }
    </style>
</head>
<body>



<!-- Edit User Section -->
<section class="edit-user-section">
    <h2>Edit User</h2>
    
    <div class="edit-form">
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?= $user['name']; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?= $user['email']; ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</section>


</body>
</html>
