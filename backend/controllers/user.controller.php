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
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user['username'];
                header('Location: /dashboard');
                exit;
            } else {
                echo "Invalid credentials.";
            }
        }
    }

    public function logout() {
        session_destroy();
    }
}