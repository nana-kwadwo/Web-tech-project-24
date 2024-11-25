<?php
session_start();
include '../functions/collection_function.php';
include '../db/databse.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection History</title>
    <link rel="stylesheet" href="../assets/css/collection_history.css">
</head>

<body>
    <a href="dashboard.php">
        <button class="back-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </button>
    </a>
    <div class="container">
        <h1 class="page-title">Collections</h1>

        <div class="collections-grid">
            <?php

            $collections = getCollections($conn);

            foreach ($collections as $collection) {
                
                ?>

                <a href=<?php echo "collection_view.php?id=". $collection['collection_id'] ?> class="collection-card">
                    <span class="collection-name"><?php echo $collection['collection_name'];
            } ?></span>
                <span class="arrow-icon">→</span>
            </a>

        </div>
    </div>
</body>

</html>