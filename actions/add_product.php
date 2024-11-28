<?php
session_start();
include '../db/databse.php';
include '../functions/collection_function.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
// global $collection_id;
// if (isset($_GET['id'])) {
//     $collection_id = $_GET['id'];
//     //var_dump($result);
//     //exit;
// }


//var_dump($_POST);
//exit();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize the product name
    $productName = trim(htmlspecialchars($_POST['product_name']));
    $collection_id = trim(htmlspecialchars($_POST['collection_id']));
   

    // Validate product name
    if (empty($productName)) {
        $_SESSION['Create_Error'] = ["Product name cannot be empty."];
        header('Location: ../view/Main.php');
        exit;
    }

    // Check if product name already exists for this user
    $stmt = $conn->prepare("SELECT product_id FROM products WHERE product_name = ? AND collection_id = ?");
    $stmt->bind_param("si", $productName, $collection_id);
    $stmt->execute();
    $result2 = $stmt->get_result();

    if ($result2->num_rows > 0) {
        $_SESSION['Create_Error'] = ["A product with this name already exists."];
        header('Location: ../view/Main.php');
        exit;
    }


    $fabricCost = $_POST['fabric_cost'];
    $deliveryCost = $_POST['delivery_cost'];
    $printingCost = $_POST['printing_cost'];
    $packagingCost = $_POST['packaging_cost'];
    $markup_percentage = $_POST['markup_percentage'];
    $numberOfUnits= $_POST['number_of_units'];
    $sewing_cost= $_POST['sewing_cost'];


    $totalCost = $fabricCost + $deliveryCost + $printingCost + $packagingCost + $sewing_cost;
    $unitCost = $totalCost / $numberOfUnits;


    $stmt = $conn->prepare("INSERT INTO products (product_name, collection_id, fabric_cost, delivery_cost, printing_cost, packaging_cost, sewing_cost, number_of_units, markup_percentage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdddddidd", $productName, $collection_id, $fabricCost, $deliveryCost, $printingCost, $packagingCost, $sewing_cost, $numberOfUnits, $markup_percentage);

    if ($stmt->execute()) {
        // Product created successfully
        updateCollectionTotalCost($collection_id);
        header('Location: ../view/existing_page.php?id=' . $collection_id);
        exit;
    } else {
        $_SESSION['Create_Error'] = ["Failed to create product. Please try again."];
        header('Location: ../view/Main.php');
        exit;
    }
}

// If accessed directly without POST data
header('Location: ../view/Main.php');
exit;

?>