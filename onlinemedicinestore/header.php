<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Medicine Store</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* 🌿 Green Navbar Styling */
        .navbar {
            background: linear-gradient(to right, #28a745, #218838); /* Gradient Green */
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 22px;
            color: white !important;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
        .navbar-brand:hover {
            transform: scale(1.1);
        }
        .navbar-nav .nav-link {
            color: white !important;
            font-size: 16px;
            margin: 0 10px;
            transition: 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #d4edda !important;
            transform: scale(1.1);
        }

        /* 🔍 Search Bar */
        .search-bar {
            position: relative;
            max-width: 300px;
            margin-left: auto;
        }
        .search-bar input {
            width: 100%;
            padding: 8px 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            outline: none;
            transition: 0.3s;
        }
        .search-bar input:focus {
            border-color: #218838;
            box-shadow: 0px 0px 5px rgba(40, 167, 69, 0.5);
        }
        .search-bar button {
            position: absolute;
            right: 10px;
            top: 5px;
            border: none;
            background: none;
            color: #218838;
            cursor: pointer;
            font-size: 16px;
        }

        /* 🚪 Login & Logout Button */
        .auth-btn {
            background: white;
            color: #28a745;
            border-radius: 20px;
            padding: 7px 15px;
            font-weight: bold;
            text-decoration: none;
            border: 2px solid #28a745;
            transition: 0.3s;
            display: inline-block;
            margin-left: 15px;
        }
        .auth-btn:hover {
            background: #218838;
            color: white;
        }
    </style>
</head>
<body>

<!-- 🌿 Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <!-- ✅ Logo and Brand -->
        <a class="navbar-brand" href="index.php">
            <!--<img src="images/logo.png" alt="Logo">--> <!-- Adjust the path -->
            💊 Online Medicine Store
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">🏠 Home</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">🛒 Cart</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="orders.php">📦 My Orders</a></li> -->
            </ul>

            <!-- 🔍 Search Bar -->
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Search Medicines...">
                    <button type="submit">🔍</button>
                </form>
            </div>

            <!-- 🚪 Login / Logout Button -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="auth-btn">🚪 Logout</a>
            <?php else: ?>
                <a href="login.php" class="auth-btn">🔑 Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
