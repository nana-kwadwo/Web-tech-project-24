<?php
include '../db/databse.php'; 

function getCollections() {
    global $conn;
    // Query to fetch all collections
    $sql = "SELECT * FROM `collections`";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch all rows into an array
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Return an empty array if no collections are found
        return [];
    }
}

function getCollection($collection_id) {
    global $conn;
    $sql = "SELECT * FROM `collections` where collection_id='$collection_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch all rows into an array
        return $result->fetch_assoc();
    } else {
        // Return an empty array if no collections are found
        return [];
    }
}


function displayProducts($conn, $collectionId) {
    if ($collectionId) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE collection_id = ?");
        $stmt->bind_param("i", $collectionId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Rest of the display logic...
    } else {
        echo "<p>Collection ID is not specified.</p>";
    }
}


function updateCollectionTotalCost($collectionId) {
    global $conn;
    
    // First, calculate totals from products
    $query = "
        SELECT 
            COALESCE(SUM(fabric_cost + delivery_cost + sewing_cost + printing_cost + packaging_cost), 0) as total_cost,
            COALESCE(SUM(break_even_cost), 0) as total_break_even,
            COALESCE(SUM(projected_revenue), 0) as projected_revenue,
            COALESCE(SUM(projected_profit), 0) as projected_profit
        FROM products 
        WHERE collection_id = ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $collectionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $totals = $result->fetch_assoc();
    
    // Then update the collections table
    $updateQuery = "
        UPDATE collections 
        SET 
            total_cost = ?,
            total_break_even = ?,
            projected_revenue = ?,
            projected_profit = ?
        WHERE collection_id = ?
    ";
    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param(
        "ddddi",
        $totals['total_cost'],
        $totals['total_break_even'],
        $totals['projected_revenue'],
        $totals['projected_profit'],
        $collectionId
    );
    
    return $stmt->execute();
}


?>
