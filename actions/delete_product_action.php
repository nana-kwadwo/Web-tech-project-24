<?php
session_start();
include '../db/databse.php'; // Include your database connection
include '../functions/collection_function.php';


// Check if the product_id is provided via POST
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // First get the collection_id before deleting the product
    $stmt = $conn->prepare("SELECT collection_id FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $collection_id = $product['collection_id'];
    
    // Now delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // Update collection totals after successful deletion
        updateCollectionTotalCost($collection_id);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete product']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No product ID provided']);
}
?>
