<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay New Kalalake - LGU Login</title>
    <link rel="icon" type="image/png" href="frontdesk/images/logo.png">
    <style>
        @font-face {
            font-family: 'Monda';
            src: url('app/fonts/Monda-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Monda', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
            margin: 0;
        }

        .login-card {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 70vh;
            border: 1px solid #e0e0e0;
        }

        .header-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .header-section h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .header-section p {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        .form-spacing > div {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 0.4rem;
        }

        input {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #dcdfe6;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            color: #34495e;
            background-color: #fdfdfd;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        input::placeholder {
            color: #b0b0b0;
        }

        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        input[type="password"] {
            padding-right: 3rem;
        }

        .password-input-container {
            position: relative;
        }

        .toggle-password-button {
            position: absolute;
            top: 50px;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password-button:hover {
            opacity: 0.8;
        }

        .toggle-password-button:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.3);
            border-radius: 50%;
        }

        .toggle-password-button img {
            height: 1.1rem;
            width: 1.1rem;
            display: block;
        }

        .hidden {
            display: none !important;
        }

        .flex-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .flex-center-items {
            display: flex;
            align-items: center;
        }

        input[type="checkbox"] {
            height: 1.1rem;
            width: 1.1rem;
            accent-color: #3498db;
            border: 1px solid #c0c0c0;
            border-radius: 0.25rem;
            cursor: pointer;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        input[type="checkbox"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.3);
        }

        .checkbox-label {
            font-size: 0.9rem;
            color: #34495e;
            cursor: pointer;
            margin-bottom: 0;
        }

        .submit-button {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 0.85rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            background-color: #3498db;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        .submit-button:hover {
            background-color: #2980b9;
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }

        .submit-button:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.4);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="header-section">
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
                    <img src="app/images/open-eye-icon.png" alt="Show Password" id="eye-open-icon">
                    <img src="app/images/close-eye-icon.png" alt="Hide Password" id="eye-closed-icon" class="hidden">
                </button>
            </div>

            <div class="flex-between">
                <div class="flex-center-items">
                    <input
                        id="remember-me"
                        name="remember-me"
                        type="checkbox"
                    >
                    <label for="remember-me" class="checkbox-label">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit" class="submit-button">Sign in</button>
            </div>
        </form>
    </div>
    <script src="app/js/togglePassword.js"></script>
</body>
</html>