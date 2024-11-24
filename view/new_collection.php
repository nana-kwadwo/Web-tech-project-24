<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Collection</title>
    <link rel="stylesheet" href="../assets/css/new_collection.css">
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <a href="dashboard.php">
        <button class="back-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </button>
        </a>
        
        <div class="collection-name">
            <form action = "../actions/add_collection.php" method = "post">
                <input type="text" placeholder="Collection Name" class="collection-title-input" value="New Collection" name = "collectionName">
                <button type = "submit">Create Collection</button>
            </form>
        </div>
        
        <button class="profile-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </button>
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
        <h2>Collection Summary</h2>
        <p><strong>Projected Revenue:</strong> ₵0.00</p>
        <p><strong>Projected Net Profit:</strong>₵0.00</p>
        <p><strong>Total Costs:</strong> ₵0.00</p>
        <p><strong>Break-Even Costs:</strong> ₵0.00</p>
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
