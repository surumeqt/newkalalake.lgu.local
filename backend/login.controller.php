<?php
session_start();
require_once __DIR__ . '/config/database.config.php';
require_once __DIR__ . '/models/user.model.php';
require_once __DIR__ . '/helpers/redirects.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $loggedInUser = $userModel->login($username, $password);

    if ($loggedInUser) {
        $_SESSION['user_id'] = $loggedInUser['user_id'];
        $_SESSION['username'] = $loggedInUser['username'];
        $_SESSION['role'] = $loggedInUser['role'];
        redirectBasedOnRole($loggedInUser['role'], '?status=success');
        exit;
    } else {
        $message = "Invalid credentials!";
    }
}
?>

<?php if (!empty($message)): ?>
    <div style="
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        text-align: center;
        font-size: 1rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    ">
        <p style="margin-bottom: 15px; font-weight: 600;"><?= htmlspecialchars($message) ?></p>
        <a href="../index.php" style="
            display: inline-block;
            background-color: #dc3545;
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