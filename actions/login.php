<?php
// Start session to manage user authentication
session_start();
include '../db/databse.php'; // Ensure the database connection file is correctly included

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and trim form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = [];

    // Validate email and password inputs
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Redirect back to login page if validation fails
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        header("Location: ../view/login.php");
        exit;
    }

    // Prepare SQL statement to verify user credentials
    $stmt = $conn->prepare("SELECT id, fname, lname, password FROM users WHERE email = ?");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Store user details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];

            // Redirect to dashboard
            header("Location: ../view/dashboard.php");
            exit;
        } else {
            // Incorrect password
            $_SESSION['login_errors'] = ["Invalid email or password."];
            header("Location: ../view/login.php");
            exit;
        }
    } else {
        // No user found with the given email
        $_SESSION['login_errors'] = ["Invalid email or password."];
        header("Location: ../view/login.php");
        exit;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
