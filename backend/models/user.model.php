<?php
require_once __DIR__ . '/../config/database.config.php';

class user {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    public function create($username, $password, $position, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, position, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $position, $role]);
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT user_id, username, position, role, createdAt FROM users");
        return $stmt->fetchAll();
    }

    public function deleteUser($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }

    public function findById($user_id) {
        $stmt = $this->conn->prepare("SELECT user_id, username, position, role FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }
}
