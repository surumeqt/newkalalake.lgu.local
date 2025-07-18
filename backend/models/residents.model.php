<?php
// backend/models/residents.model.php
require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/../helpers/formatters.php'; // Needed for generateRandomIds and other formatters

class Residents
{
    private $conn;
    private $table_name = "residents";

    public function __construct()
    {
        $db = new Connection(); // Assuming Connection class from database.config.php
        $this->conn = $db->connect();
    }

    public function addResident($data)
    {
        // SQL query to insert new resident data
        $query = "INSERT INTO " . $this->table_name . " (
            resident_id, first_name, middle_name, last_name, suffix,
            birthday, age, gender, civil_status,
            house_number, street, purok, barangay, city,
            email, contact_number
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?
        )";

        try {
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
                $data['house_number'],
                $data['street'],
                $data['purok'],
                $data['barangay'],
                $data['city'],
                $data['email'],
                $data['contact_number']
            ]);

            // Handle photo upload if a file is provided (existing logic)
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Assuming you have a method to handle photo uploads, e.g., uploadPhoto($residentId, $file)
                // This part is not fully implemented here as it's outside the direct scope of the initial request,
                // but conceptually, you'd call a method to save the photo to a designated folder
                // and potentially store the path in the database.
            }

            return true;
        } catch (PDOException $e) {
            error_log("Error adding resident: " . $e->getMessage());
            return false;
        }
    }
    
    public function getResidents()
    {
        $sql = "SELECT * FROM residents";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting residents: " . $e->getMessage());
            return [];
        }
    }

    public function getResidentsByName($data)
    {
        $sql = "SELECT * FROM residents WHERE first_name LIKE ? OR last_name LIKE ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['%' . $data . '%', '%' . $data . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting residents by name: " . $e->getMessage());
            return [];
        }
    }

    // Modified to accept string for resident_id
    public function getResidentById(string $residentId): ?array
    {
        $sql = "SELECT * FROM residents WHERE resident_id = :resident_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':resident_id', $residentId, PDO::PARAM_STR); // Use PARAM_STR for varchar
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null; // Return array if found, null otherwise
        } catch (PDOException $e) {
            error_log("Error fetching resident by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getTotalResidentsCount(string $searchQuery = ''): int
    {
        $sql = "SELECT COUNT(*) FROM residents";
        $params = [];
        if (!empty($searchQuery)) {
            // Updated search to include new address fields
            $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR house_number LIKE ? OR street LIKE ? OR purok LIKE ? OR barangay LIKE ? OR city LIKE ? OR gender LIKE ? OR birthday LIKE ?";
            $likeQuery = '%' . $searchQuery . '%';
            $params = array_fill(0, 9, $likeQuery); // Fill parameters for 9 placeholders
        }
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error getting total residents count: " . $e->getMessage());
            return 0;
        }
    }

    public function getResidentsPaginated(int $limit, int $offset, string $searchQuery = ''): array
    {
        $sql = "SELECT * FROM residents";
        $params = [];
        if (!empty($searchQuery)) {
            // Updated search to include new address fields
            $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR house_number LIKE ? OR street LIKE ? OR purok LIKE ? OR barangay LIKE ? OR city LIKE ? OR gender LIKE ? OR birthday LIKE ?";
            $likeQuery = '%' . $searchQuery . '%';
            $params = array_fill(0, 9, $likeQuery); // Fill parameters for 9 placeholders
        }
        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting paginated residents: " . $e->getMessage());
            return [];
        }
    }

    public function updateResident($residentId, $data)
    {
        $setParts = [];
        $params = [':resident_id' => $residentId];

        foreach ($data as $key => $value) {
            // Exclude 'age' if it somehow makes it into $data for update
            // Also, 'address' might be re-generated from its parts if a form sends parts separately
            if ($key !== 'age') {
                $setParts[] = "`{$key}` = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        if (empty($setParts)) {
            return true; // No data to update
        }

        $sql = "UPDATE `residents` SET " . implode(', ', $setParts) . " WHERE `resident_id` = :resident_id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error updating resident: " . $e->getMessage());
            return false;
        }
    }
}