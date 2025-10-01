<?php
include 'config.php';

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete user query
    $query = "DELETE FROM users WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        header("Location: manage_users.php"); // Redirect back
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>
