<?php
include '../db/databse.php';
// View product details function
function viewProductDetails($productId) {
    global $conn;
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // No product found
    }
}


?>
