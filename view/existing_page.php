<?php
include '../functions/collection_function.php'; 

if(isset($_GET['id'])){
    $result = getCollection($_GET['id']);
    
    //var_dump($result);
    //exit;
}

if(isset($_GET['id'])){
    $summary_result= getCollectionSummary($_GET['id']);
    //var_dump( $summary_result );
    //exit;
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
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </button>
        </a>
        
        <div class="collection-name">
           <h3> <?php echo $result['collection_name']?> </h3>
        </div>
        
        <button class="profile-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </button>
    </div>

    <!-- Products Grid Section -->
    <div class="products-grid">
        <!-- Product Card 1 -->
        <div class="product-card">
            <div class="product-image">
                <img src="/api/placeholder/400/500" alt="Product 1">
            </div>
            <div class="product-actions">
                <a href="main.php">
                <button class="icon-btn edit-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
                </a>
                <button class="icon-btn delete-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- More Product Cards can go here -->

    </div>

    <!-- Add Product Button -->
    <a href="main.php">
    <button class="add-product-btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
    </button></a>

    <!-- Collection Summary Section -->
    <div class="collection-summary">
        <h2><?php echo $result['collection_name']?> Summary </h2>
        <p><strong>Projected Revenue:</strong>₵<?php echo $summary_result['projected_revenue']?> </p>
        <p><strong>Projected Net Profit:</strong>₵<?php echo $summary_result['projected_profit']?></p>
        <p><strong>Total Costs:</strong> ₵<?php echo $summary_result['total_cost']?></p>
        <p><strong>Break-Even Costs:</strong> ₵<?php echo $summary_result['total_break_even']?></p>
    </div>

    <script>
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
