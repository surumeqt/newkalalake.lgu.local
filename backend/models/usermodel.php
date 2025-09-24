<?php
namespace backend\models;

use backend\config\Connection;

class usermodel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_name = :user_name");
        $stmt->execute(['user_name' => $username]);
        return $stmt->fetch();
    }
}