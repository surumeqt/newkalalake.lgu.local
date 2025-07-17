<?php
session_start();
require_once __DIR__ . '/config/database.config.php';
require_once __DIR__ . '/models/user.model.php';
require_once __DIR__ . '/helpers/redirects.php';

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
        $error = 'Invalid credentials!';
    }
}

?>

<div style="background-color: white; padding: 10px; border-radius: 20px; flex-grow: 1; text-align: center;">
    <?php if (!empty($error)): ?>
        <p style="color: red; font-weight: bold; margin-bottom: 10px;"><?php echo $error; ?></p>
        <a href="../index.php" style="color: blue; text-decoration: underline;">Go back to login</a>
    <?php else: ?>
        <p class="text-green-600 font-bold mb-4">Processing login...</p>
    <?php endif; ?>
</div>