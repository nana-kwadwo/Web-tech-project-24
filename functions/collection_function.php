<?php
include '../db/databse.php'; 

function getCollections($conn) {
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
?>