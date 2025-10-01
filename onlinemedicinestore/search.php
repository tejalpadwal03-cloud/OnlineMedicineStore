<?php
include 'config.php'; // Database connection
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Medicines</title>
    
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }
    
    .search-container {
        text-align: center;
        padding: 20px;
    }

    /* Decrease Font Size of Search Input */
    .search-container input[type="text"] {
        width: 60%;
        padding: 8px;
        font-size: 14px; /* Decreased from 16px */
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-container button {
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        background: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    .results-container {
        width: 80%;
        margin: 20px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    /* Change Table Header to Dark Green */
    th {
        background: #006400; /* Dark Green */
        color: white;
    }

    tr:nth-child(even) {
        background: #f2f2f2;
    }

    p {
        font-size: 18px;
        text-align: center;
        color: #dc3545;
    }
</style>

</head>
<body>

<div class="search-container">
    <form action="search.php" method="GET">
        <input type="text" name="query" list="medicineList" placeholder="Search for medicines..." required>
        <datalist id="medicineList">
            <?php
            include 'config.php'; // Database connection
            $sql = "SELECT name FROM medicines";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['name']) . "'>";
                }
            }
            ?>
        </datalist>
        <button type="submit">Search</button>
    </form>
</div>

<div class="results-container">
    <?php
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $search = trim($_GET['query']);

        // Fetch matching medicines
        $sql = "SELECT name, category, price, stock FROM medicines WHERE name LIKE ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $searchParam = "%" . $search . "%";
            $stmt->bind_param("s", $searchParam);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h2>Search Results for: <strong>" . htmlspecialchars($search) . "</strong></h2>";

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price (₹)</th>
                            <th>Stock</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['category']) . "</td>
                            <td>₹" . number_format($row['price'], 2) . "</td>
                            <td>" . $row['stock'] . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No medicines found for '<strong>" . htmlspecialchars($search) . "</strong>'.</p>";
            }

            $stmt->close();
        }
    }
    ?>
</div>



</body>
</html>

<?php $conn->close(); ?>
