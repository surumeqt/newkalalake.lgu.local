<?php
require_once __DIR__ . '/../config/database.config.php';

class CertificateModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }
    public function createCertificate($data) {
        
    }
}