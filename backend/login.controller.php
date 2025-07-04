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
        echo "Invalid credentials!";
    }
}
