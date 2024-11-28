<?php
include '../functions/collection_function.php';
include '../db/databse.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$collections = getCollections();
if (isset($_GET['id'])) {
    $result = getCollection($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Collection</title>
    <link rel="stylesheet" href="../assets/css/existing_page.css">
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <a href="collection_history.php">
            <button class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
            </button>
        </a>

        <div class="collection-name">
            <h3> <?php echo $result['collection_name'] ?></h3>
        </div>

        <button class="profile-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
        </button>
    </div>

    <!-- Products Grid Section -->
    <div class="products-grid">
        <!-- Product Card 1 -->
       <?php displayProducts($conn); ?>

        <!-- More Product Cards can go here -->
 
    </div>

    <!-- Add Product Button -->
    <a href="Main.php?id=<?php  echo $result['collection_id']; ?>">
        <button class="add-product-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
        </button>
    </a>

    <!-- Collection Summary Section -->
    <div class="collection-summary">
        <h2><?php echo $result['collection_name'] ?> Summary </h2>
        <p><strong>Projected Revenue:</strong>₵<?php echo $result['projected_revenue'] ?></p>
        <p><strong>Projected Net Profit:</strong>₵<?php echo $result['projected_profit'] ?></p>
        <p><strong>Total Costs:</strong> ₵<?php echo $result['total_cost'] ?></p>
        <p><strong>Break-Even Costs:</strong> ₵<?php echo $result['total_break_even'] ?></p>
    </div>

    <script>


function deleteProduct(productId) {
    // Confirm before deleting
    if (confirm("Are you sure you want to delete this product?")) {
        // Send an AJAX request to delete the product
        fetch('../actions/delete_product_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId // Send the product ID to the server
        })
        .then(response => response.json()) // Expecting a JSON response
        .then(data => {
            if (data.success) {
                // If deletion is successful, alert the user and reload the page
                alert('Product deleted successfully.');
                location.reload(); // Reload the page to update the product list
            } else {
                alert('Failed to delete the product. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the product.');
        });
    }
}

        const collectionInput = document.querySelector('.collection-title-input');
        collectionInput.addEventListener('focus', () => {
            collectionInput.select();
        });

        const backButton = document.querySelector('.back-btn');
        backButton.addEventListener('click', () => {
            window.history.back();
        });
    </script>
</body>

</html>