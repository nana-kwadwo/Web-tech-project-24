<?php
session_start();
include '../db/databse.php'; // Ensure the database connection file is correctly included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $collectionName = trim($_POST['collectionName']);
    $user_id = $_SESSION['user_id'];
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT `collection_name` FROM `collections` WHERE `collection_name` = ?");
    $stmt->bind_param("s", $collectionName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['Create Error'] = ["Collection already exist."];
        header('Location: ../view/new_collection.php');
        exit;
    }

    // Hash the password

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO collections (collection_name, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $collectionName, $user_id);

    if ($stmt->execute()) {
        header('Location: ../view/new_collection.php'); // Redirect to login page
        exit;
    } else {
        $_SESSION['signup_errors'] = ["Registration failed. Please try again."];
        header('Location: ../view/signup.php');
        exit;
    }
}
?>
