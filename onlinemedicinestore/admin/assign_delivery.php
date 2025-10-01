<?php
session_start();
include('config.php');

if (!isset($_SESSION['admin_id'])) {
    die("Access Denied.");
}

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$order_id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_person = intval($_POST['delivery_person']);

    $sql = "UPDATE orders SET delivery_person = ?, delivery_status = 'Assigned' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $delivery_person, $order_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Delivery assigned successfully!";
        header("Location: manage_orders.php");
        exit();
    } else {
        die("Database Error: " . $stmt->error);
    }
}

// Fetch delivery persons
$result = $conn->query("SELECT * FROM delivery_persons");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Delivery</title>
</head>
<body>

<h2>Assign Delivery</h2>
<form method="POST" action="">
    <label>Select Delivery Person:</label>
    <select name="delivery_person">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
        <?php } ?>
    </select>

    <button type="submit">Assign</button>
</form>

</body>
</html>
