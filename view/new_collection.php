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
        
        <div class="header-title">
            <h1>Create New Collection</h1>
        </div>
        
        <button class="profile-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </button>
    </div>

    <!-- Collection Creation Form -->
    <div class="create-collection-container">
        <form action="../actions/add_collection.php" method="post" class="collection-form">
            <?php if(isset($_SESSION['Create_Error'])): ?>
                <div class="error-message">
                    <?php 
                        foreach($_SESSION['Create_Error'] as $error){
                            echo $error . "<br>";
                        }
                        unset($_SESSION['Create_Error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <input type="text" 
                   name="collectionName" 
                   placeholder="Enter Collection Name" 
                   required 
                   class="collection-input">
            <button type="submit" class="create-btn">Create Collection</button>
        </form>
    </div>
</body>
</html>