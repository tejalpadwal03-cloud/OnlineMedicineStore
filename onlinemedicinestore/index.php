<?php
session_start();
include 'config.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Medicine Store</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        .hero-section {
            background: url('images/banner3.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 60px 20px;
            height: 60vh;
        }
        .medicine-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="hero-section">
    <h1>Welcome to Online Medicine Store</h1>
    <p>Buy medicines online with ease and convenience.</p>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Available Medicines</h2>

    <?php
    $query = "SELECT * FROM medicines WHERE stock > 0";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<div class='row justify-content-center'>";

        while ($row = $result->fetch_assoc()) {
            $imagePath = "images/default.jpg";
            if (strtolower($row['name']) == "paracetamol") {
                $imagePath = "images/paracetamol.jpg";
            } elseif (strtolower($row['name']) == "aspirin") {
                $imagePath = "images/aspirin.jpg";
            } elseif (strtolower($row['name']) == "cough syrup") {
                $imagePath = "images/cough_syrup.jpg";
            }elseif (strtolower($row['name']) == "ibuprofen") {
                $imagePath = "images/Ibuprofen.jpg";
            }elseif (strtolower($row['name']) == "cetirizine") {
                $imagePath = "images/Cetirizine.png";
            }elseif (strtolower($row['name']) == "ciprofloxacin") {
                $imagePath = "images/ciprofloxacin.png";
            }elseif (strtolower($row['name']) == "doxycycline") {
                $imagePath = "images/Doxycycline.png";
            }elseif (strtolower($row['name']) == "amoxicillin") {
                $imagePath = "images/Amoxicillin.png";
            }elseif (strtolower($row['name']) == "metformin") {
                $imagePath = "images/Metformin.png";
            }elseif (strtolower($row['name']) == "loratadine") {
                $imagePath = "images/Loratadine.png";
            }elseif (strtolower($row['name']) == "omeprazole") {
                $imagePath = "images/Omeprazole.png";
            }




            echo "<div class='col-md-3 col-sm-6 mb-4'>";
            echo "  <div class='card border-success shadow-sm text-center p-3'>";
            echo "      <img src='$imagePath' class='medicine-img' alt='{$row['name']}'>";
            echo "      <div class='card-body'>";
            echo "          <h5 class='card-title'>{$row['name']}</h5>";
            echo "          <p class='card-text'>{$row['category']}</p>";
            echo "          <p class='fw-bold text-success'>₹{$row['price']}</p>";
            echo "          <p class='small text-muted'>Stock: {$row['stock']}</p>";
            echo "          <p class='small text-muted'>Manufacture Date: " . date("d-M-Y", strtotime($row['manufacture_date'])) . "</p>";
            echo "          <p class='small text-danger'>Expiry Date: " . date("d-M-Y", strtotime($row['expiry_date'])) . "</p>";

            if (isset($_SESSION['user_id'])) {
                echo "      <form action='cart.php' method='POST'>";
                echo "          <input type='hidden' name='medicine_id' value='{$row['id']}'>";
                echo "          <button type='submit' class='btn btn-success btn-sm w-100'>🛒 Add to Cart</button>";
                echo "      </form>";
            } else {
                echo "      <a href='login.php' class='btn btn-outline-success btn-sm w-100'>Login to Shop</a>";
            }

            echo "      </div>";
            echo "  </div>";
            echo "</div>";
        }

        echo "</div>";
    } else {
        echo "<div class='alert alert-warning text-center'>No medicines available.</div>";
    }
    ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php include 'footer.php'; ?>
