<?php
include 'config.php';

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM medicines WHERE id = $id";
    
    if ($conn->query($query) === TRUE) {
        echo "Medicine deleted successfully!";
        header("Location: manage_products.php"); // Redirect back after deletion
        exit;
    } else {
        echo "Error deleting medicine: " . $conn->error;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>
