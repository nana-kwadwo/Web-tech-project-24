<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'fashioncostsimulator';

try {
    // Create a new database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check for connection errors
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

  
    // If connection is successful, you can add a debug statement (optional)
    // echo "Connected successfully";
} catch (Exception $e) {
    // Handle the exception and display the error message
    error_log("Database connection error: " . $e->getMessage(), 0);
    die("Problem");
}
?>