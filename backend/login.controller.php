<?php
require_once __DIR__ . '/models/user.model.php';
require_once __DIR__ . '/helpers/route.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userModel = new UserModel();
    $user = $userModel->auth($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        redirectBasedOnRole($user['role'], '?status=success');
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}