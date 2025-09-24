<?php
namespace backend\models;

use backend\config\Connection;

class usermodel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }
}