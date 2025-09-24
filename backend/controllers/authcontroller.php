<?php

namespace backend\controllers;

use backend\models\usermodel;

class authcontroller {
    private $userModel;

    public function __construct() {
        $this->userModel = new usermodel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['user_pass'])) {
                session_start();
                $_SESSION['user'] = $user['user_name'];
                $_SESSION['role'] = $user['user_role'];
                redirect($user['user_role']);
                exit;
            } else {
                echo "Invalid credentials.";
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        session_unset();
        header("Location: /public/login.php");
        exit;
    }
}