<?php
session_start();
include '../db/databse.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize the collection name
    $collectionName = trim(htmlspecialchars($_POST['collectionName']));
    $user_id = $_SESSION['user_id'];
    
    // Validate collection name
    if (empty($collectionName)) {
        $_SESSION['Create_Error'] = ["Collection name cannot be empty."];
        header('Location: ../view/new_collection.php');
        exit;
    }
    
    // Check if collection name already exists for this user
    $stmt = $conn->prepare("SELECT collection_id FROM collections WHERE collection_name = ? AND user_id = ?");
    $stmt->bind_param("si", $collectionName, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['Create_Error'] = ["A collection with this name already exists."];
        header('Location: ../view/new_collection.php');
        exit;
    }

    // Insert the new collection
    $stmt = $conn->prepare("INSERT INTO collections (collection_name, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $collectionName, $user_id);

    if ($stmt->execute()) {
        // Get the new collection's ID
        $collection_id = $stmt->insert_id;
        
        // Initialize collection summary
        $stmt = $conn->prepare("INSERT INTO collection_summary (collection_id, total_cost, total_break_even, projected_revenue, projected_profit) VALUES (?, 0, 0, 0, 0)");
        $stmt->bind_param("i", $collection_id);
        $stmt->execute();
        
        header('Location: ../view/collection_history.php');
        exit;
    } else {
        $_SESSION['Create_Error'] = ["Failed to create collection. Please try again."];
        header('Location: ../view/new_collection.php');
        exit;
    }
}

// If accessed directly without POST data
header('Location: ../view/new_collection.php');
exit;
?>