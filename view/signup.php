<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up</title>
    <link rel="stylesheet" href="../assets/css/sign_up_style.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <!-- Display server-side errors -->
        <?php
        session_start();
        if (!empty($_SESSION['signup_errors'])) {
            foreach ($_SESSION['signup_errors'] as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
            unset($_SESSION['signup_errors']);
        }
        ?>
        <form id="signupForm" action="../actions/signup.php" method="POST">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="fName" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lName" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="password-strength" id="passwordStrength"></div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <span id="confirmPasswordError" class="error"></span>
            </div>
            <button type="submit">Signup</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
    <script src="../assets/js/password_validation.js"></script>
</body>
</html>
