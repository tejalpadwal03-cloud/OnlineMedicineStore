<?php
include 'config.php'; // Include database connection

if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
    $sql = "SELECT name FROM medicines WHERE name LIKE ? LIMIT 5";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $searchParam = "%" . $search . "%";
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();

        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = $row['name'];
        }

        echo json_encode($suggestions); // Return results in JSON format
    }
    $stmt->close();
}
$conn->close();
?>
