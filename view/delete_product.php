<?php
// Database connection
include 'db/databse.php'; // Ensure this path matches your setup

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product_id from the request
    $product_id = $_POST['product_id'];

    // Ensure the product_id is provided
    if (empty($product_id)) {
        echo json_encode(["status" => "error", "message" => "Product ID is required."]);
        exit;
    }

    // Prepare the SQL query
    $sql = "DELETE FROM products WHERE product_id = ?";

    // Execute the query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Product deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete product."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to prepare statement."]);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
