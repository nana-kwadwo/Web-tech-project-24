<?php
include '../db/databse.php';
include '../functions/collection_function.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $productName = isset($_POST['product_name']) ? trim($_POST['product_name']) : null;
    $fabricCost = isset($_POST['fabric_cost']) ? floatval($_POST['fabric_cost']) : 0.00;
    $printingCost = isset($_POST['printing_cost']) ? floatval($_POST['printing_cost']) : 0.00;
    $sewing_cost = isset($_POST['sewing_cost']) ? floatval($_POST['sewing_cost']) : 0.00;
    $packagingCost = isset($_POST['packaging_cost']) ? floatval($_POST['packaging_cost']) : 0.00;
    $deliveryCost = isset($_POST['delivery_cost']) ? floatval($_POST['delivery_cost']) : 0.00;
    $numberOfUnits = isset($_POST['number_of_units']) ? intval($_POST['number_of_units']) : 0;
    $markupPercentage = isset($_POST['markup_percentage']) ? floatval($_POST['markup_percentage']) : 0.00;

    // Validate required fields
    if (!$productId || !$productName) {
        die("Product ID and name are required.");
    }

    // Prepare SQL to update the product
    $query = "UPDATE products 
              SET 
                  product_name = ?, 
                  fabric_cost = ?, 
                  printing_cost = ?, 
                  sewing_cost = ?,
                  packaging_cost = ?, 
                  delivery_cost = ?, 
                  number_of_units = ?, 
                  markup_percentage = ? 
              WHERE product_id = ?";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "sdddddidi", 
        $productName, 
        $fabricCost, 
        $printingCost, 
        $sewing_cost,
        $packagingCost, 
        $deliveryCost, 
        $numberOfUnits, 
        $markupPercentage, 
        $productId
    );

    // Execute the query
    if ($stmt->execute()) {
        updateCollectionTotalCost($collection_id);
        // Redirect to the product details page or display a success message
        header("Location: ../view/collection_history.php");
        exit();
    } else {
        die("Error updating product: " . $stmt->error);
    }
} else {
    // Handle cases where the script is accessed without a POST request
    die("Invalid request method.");
}
?>
