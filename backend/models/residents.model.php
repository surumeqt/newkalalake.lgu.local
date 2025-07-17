<?php
require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/../helpers/formatters.php';
class Residents {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    public function addResident($data) {
        $sql = "INSERT INTO residents (
                    resident_id, first_name, middle_name, last_name, suffix,
                    birthday, age, gender, civil_status,
                    address, email, contact_number
                ) VALUES (
                    ?, ?, ?, ?, ?,
                    ?, ?, ?, ?,
                    ?, ?, ?
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            generateRandomIds(),
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['suffix'],
            $data['birthday'],
            $data['age'],
            $data['gender'],
            $data['civil_status'],
            $data['address'],
            $data['email'],
            $data['contact_number']
        ]);
    }

    public function getResidents() {
        $sql = "SELECT * FROM residents";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getResidentsByName($data) {
        $sql = "SELECT * FROM residents WHERE first_name LIKE :name OR last_name LIKE :name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':name' => '%' . $_POST['search'] . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}