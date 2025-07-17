<?php
require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/../helpers/formatters.php';
require_once __DIR__ . '/../config/database.config.php';

class Residents {
    private $conn;
    private $table_name = "residents";

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
        $sql = "SELECT * FROM residents WHERE first_name LIKE ? OR last_name LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['%' . $data . '%', '%' . $data . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // New method to get a single resident by ID
    public function getResidentById(int $residentId): ?array
    {
        $sql = "SELECT * FROM residents WHERE resident_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$residentId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null; // Return array if found, null otherwise
    }
    // Modified to include Name, Address, Gender, Birth Date in search
    public function getTotalResidentsCount(string $searchQuery = ''): int
    {
        $sql = "SELECT COUNT(*) FROM residents";
        $params = [];
        if (!empty($searchQuery)) {
            $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR address LIKE ? OR gender LIKE ? OR birthday LIKE ?";
            // You might also want to include middle_name and suffix here for a more comprehensive name search
            $likeQuery = '%' . $searchQuery . '%';
            $params = [$likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery];
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    // Modified to include Name, Address, Gender, Birth Date in search
    public function getResidentsPaginated(int $limit, int $offset, string $searchQuery = ''): array
    {
        $sql = "SELECT * FROM residents";
        $params = [];
        if (!empty($searchQuery)) {
            $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR address LIKE ? OR gender LIKE ? OR birthday LIKE ?";
            // You might also want to include middle_name and suffix here for a more comprehensive name search
            $likeQuery = '%' . $searchQuery . '%';
            $params = [$likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery];
        }
        $sql .= " ORDER BY created_at ASC LIMIT ? OFFSET ?"; // Order by most recent first
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}