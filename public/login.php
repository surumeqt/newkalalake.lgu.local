<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay New Kalalake - LGU Login</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="css/entry.css">
</head>
<body>
    <div class="login-card">
        <div class="header-section">
            <img src="assets/logo.png" alt="brgylogo">
            <h1>Barangay New Kalalake - LGU</h1>
            <p>Data Encoding & Database Login</p>
        </div>

        <!-- Login Form -->
        <form class="form-spacing" action="backend/login.controller.php" method="POST">
            <div>
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="you@example.com"
                >
            </div>
            <div class="password-input-container">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="••••••••"
                >
                <!-- Eye Icon Button -->
                <button
                    type="button"
                    id="togglePassword"
                    class="toggle-password-button"
                >
                    <img src="assets/open-eye-icon.png" alt="Show Password" id="eye-open-icon">
                    <img src="assets/close-eye-icon.png" alt="Hide Password" id="eye-closed-icon" class="hidden">
                </button>
            </div>
            <div>
                <button type="submit" class="submit-button">Sign in</button>
            </div>
        </form>
    </div>
    <script src="js/togglePassword.js"></script>
</body>
</html>