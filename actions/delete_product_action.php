<?php
session_start();
include '../db/databse.php'; // Include your database connection

// Check if the product_id is provided via POST
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // Deletion successful, send a success response
        echo json_encode(['success' => true]);
    } else {
        // Deletion failed, send an error response
        echo json_encode(['success' => false]);
    }
} else {
    // Invalid request (no product_id)
    echo json_encode(['success' => false]);
}
?>
