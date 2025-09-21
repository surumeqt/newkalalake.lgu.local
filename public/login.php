<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>LOGIN</h2>
            <form action="../backend/login.controller.php" method="post" class="login-form">
                <div class="input-container">
                    <input type="text" id="username" placeholder="Username" name="username" required>
                    <img src="assets/icons/user.png" class="icon">
                </div>
                <div class="input-container">
                    <input type="password" id="password" placeholder="Password" name="password" required>
                    <img src="assets/icons/lock.png" class="icon toggle-password" id="toggle-password-hide">
                    <img src="assets/icons/unlock.png" class="icon toggle-password-show" id="toggle-password-show">
                </div>
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="login-button">Log In</button>
            </form>
        </div>
    </div>
    <script src="js/togglePassword.js"></script>
</body>
</html>
