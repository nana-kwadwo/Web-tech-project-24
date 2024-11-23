<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/sign_up_style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <!-- Display server-side errors -->
        <?php
        session_start();
        if (!empty($_SESSION['login_errors'])) {
            foreach ($_SESSION['login_errors'] as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
            unset($_SESSION['login_errors']);
        }
        ?>
        <form id="loginForm" action="../actions/login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Log-In</button>
        </form>
        <p>Don't Have an Account? <a href="signup.php">Sign up here</a></p>
        <div id="message"></div>
    </div>
</body>
</html>
