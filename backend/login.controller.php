<?php
session_start();
require_once __DIR__ . '/config/database.config.php';
require_once __DIR__ . '/models/user.model.php';
require_once __DIR__ . '/helpers/redirects.php';

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $loggedInUser = $userModel->login($username, $password);

    if ($loggedInUser) {
        $_SESSION['user_id'] = $loggedInUser['user_id'];
        $_SESSION['username'] = $loggedInUser['username'];
        $_SESSION['role'] = $loggedInUser['role'];
        redirectBasedOnRole($loggedInUser['role']);
        exit;
    } else {
        $message = "Invalid credentials!";
    }
}
?>

<?php if (!empty($message)): ?>
    <div style="
        background-color: #f8d7da; /* Light red background */
        color: #721c24; /* Dark red text */
        border: 1px solid #f5c6cb; /* Red border */
        padding: 15px 20px; /* Increased padding */
        margin-bottom: 20px;
        border-radius: 8px; /* Slightly more rounded corners */
        text-align: center;
        font-size: 1rem; /* Slightly larger font */
        max-width: 400px; /* Adjust as needed for your layout */
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Subtle shadow */
    ">
        <p style="margin-bottom: 15px; font-weight: 600;"><?= htmlspecialchars($message) ?></p>
        <a href="../index.php" style="
            display: inline-block;
            background-color: #dc3545; /* Red button style */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        ">
            Go Back to Login
        </a>
    </div>
<?php endif; ?>