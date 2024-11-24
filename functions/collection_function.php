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

function getCollectionSummary($summary_id){
    global $conn;
    $sql="SELECT * from `collection_summary` where summary_id='$summary_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch all rows into an array
        return $result->fetch_assoc();
    } else {
        // Return an empty array if no collections are found
        return [];
    }}
?>
