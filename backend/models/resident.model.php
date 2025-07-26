<?php
require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/../helpers/formatters.php';

class ResidentModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    public function createResident($data) {
        $query = "INSERT INTO residents (
            resident_id, first_name, middle_name, last_name, suffix,
            birthday, age, gender, civil_status, address,
            contact_number, email
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?
        )";
        $stmt = $this->conn->prepare($query);
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
            formatAddress($data),
            $data['contact'],
            $data['email']
        ]);
    }
    public function getResidents(){
        $query = "SELECT * FROM residents";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteResident($id){
        $query = "DELETE FROM residents WHERE resident_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
    public function searchByLnameOrFname($searchInput){
        $query = "SELECT * FROM residents WHERE last_name LIKE ? OR first_name LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['%' . $searchInput . '%', '%' . $searchInput . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findByFullName($name) {
        $query = "SELECT * FROM residents WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) = :name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}