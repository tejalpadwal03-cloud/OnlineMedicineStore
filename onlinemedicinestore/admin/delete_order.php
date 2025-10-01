<?php
session_start();
include('config.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = intval($_POST['order_id']);
        
        $sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        
        if ($stmt->execute()) {
            header("Location: manage_orders.php?success=Order deleted successfully");
            exit();
        } else {
            header("Location: manage_orders.php?error=Failed to delete order");
            exit();
        }
    }
} else {
    header("Location: manage_orders.php");
    exit();
}
?>
