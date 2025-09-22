<?php
require_once __DIR__ . '/models/user.model.php';
require_once __DIR__ . '/helpers/redirects.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if (!$username || !$password) {
                return "Please provide both username and password.";
            }

            $user = $this->userModel->auth($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];

                redirectBasedOnRole($user['role'], '?status=success');
                exit();
            } else {
                return "Invalid username or password.";
            }
        }
    }
}
