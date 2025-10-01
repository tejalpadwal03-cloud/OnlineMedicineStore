<?php 
include 'config.php';
include 'header.php';

$search = $_GET['search'] ?? '';
?>

<div class="medicines-container">
    <h2>Search Medicines</h2>

    <!-- Search Bar -->
    <form method="GET" action="medicines.php" class="search-form">
        <input type="text" name="search" placeholder="Search medicines..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <div class="medicines-list">
        <?php
        $query = "SELECT * FROM medicines WHERE name LIKE '%$search%' AND stock > 0";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='medicine-item'>";
                echo "<h3>{$row['name']}</h3>";
                echo "<p>{$row['description']}</p>";
                echo "<p class='price'>₹{$row['price']}</p>";
                echo "<p class='stock'>Stock: {$row['stock']}</p>";
                echo "<a href='cart.php?add={$row['id']}' class='add-to-cart-btn'>Add to Cart</a>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-medicines'>No medicines found.</p>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
