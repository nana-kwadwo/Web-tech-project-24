<?php
session_start();
include '../db/databse.php'; // Ensure the database connection file is correctly included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $errors = [];

    // Server-side validation
    if (empty($fName)) $errors[] = "First name is required.";
    if (empty($lName)) $errors[] = "Last name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (!empty($errors)) {
        $_SESSION['signup_errors'] = $errors;
        header('Location: ../view/signup.php');
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM fashion_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['signup_errors'] = ["Email is already registered."];
        header('Location: ../view/signup.php');
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO fashion_users (fname, lname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fName, $lName, $email, $hashedPassword);

    if ($stmt->execute()) {
        header('Location: ../view/login.php'); // Redirect to login page
        exit;
    } else {
        $_SESSION['signup_errors'] = ["Registration failed. Please try again."];
        header('Location: ../view/signup.php');
        exit;
    }
}
?>
