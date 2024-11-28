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
        echo "<div class='product-list'>";
        while ($product = $result->fetch_assoc()) {
            echo "<div class='product-card'>";
            
            // Product image
            echo "<div class='product-image'>";
            echo  htmlspecialchars($product['product_name']) ;
            echo "</div>";
            
            // Product actions
            echo "<div class='product-actions'>";
            
            // Edit button (redirects to an edit page with the product ID)
            echo "<a href='edit.php?id=" . $product['product_id'] . "'>";
            echo "<button class='icon-btn edit-btn'>";
            echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
            echo '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />';
            echo '<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />';
            echo '</svg>';
            echo "</button>";
            echo "</a>";
            
            // Delete button (handles deletion via JavaScript or form submission)
            echo "<button class='icon-btn delete-btn' onclick='deleteProduct(" . $product['product_id'] . ")'>";
            echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
            echo '<path d="M3 6h18" />';
            echo '<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />';
            echo '</svg>';
            echo "</button>";
            
            
            echo "</div>"; // End product-actions
            echo "</div>"; // End product-card
        }
    } else {
        echo "<p>No Items found.</p>";
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
