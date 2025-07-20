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
        $query = "INSERT INTO " . $this->table_name . " (
            resident_id, first_name, middle_name, last_name, suffix,
            birthday, age, gender, civil_status,
            house_number, street, purok, barangay, city,
            email, contact_number, photo_path, is_banned, created_at, updated_at
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, NOW(), NOW()
        )";

        try {
            $stmt = $this->conn->prepare($query);

            // Default new residents to not banned
            $isBanned = 0;

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
                $data['contact_number'],
                $data['photo_path'] ?? null,
                $isBanned // Set is_banned to 0 (false) for new residents
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Error adding resident: " . $e->getMessage());
            return false;
        }
    }

    public function getResidents()
    {
        $sql = "SELECT * FROM " . $this->table_name;
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
        $sql = "SELECT * FROM " . $this->table_name . " WHERE first_name LIKE ? OR last_name LIKE ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['%' . $data . '%', '%' . $data . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting residents by name: " . $e->getMessage());
            return [];
        }
    }

    public function getResidentById(string $residentId): ?array
    {
        // CORRECTED: Select 'is_banned' column
        $sql = "SELECT *, photo_path, is_banned FROM " . $this->table_name . " WHERE resident_id = :resident_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':resident_id', $residentId, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching resident by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getTotalResidentsCount(string $searchQuery = ''): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->table_name;
        $params = [];
        if (!empty($searchQuery)) {
            $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR house_number LIKE ? OR street LIKE ? OR purok LIKE ? OR barangay LIKE ? OR city LIKE ? OR gender LIKE ? OR birthday LIKE ?";
            $likeQuery = '%' . $searchQuery . '%';
            $params = array_fill(0, 9, $likeQuery);
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
        // CORRECTED: Ensure 'is_banned' is selected for pagination as well
        $sql = "SELECT *, photo_path, is_banned FROM " . $this->table_name;
        $params = [];
        if (!empty($searchQuery)) {
            $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR house_number LIKE ? OR street LIKE ? OR purok LIKE ? OR barangay LIKE ? OR city LIKE ? OR gender LIKE ? OR birthday LIKE ?";
            $likeQuery = '%' . $searchQuery . '%';
            $params = array_fill(0, 9, $likeQuery);
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
            if ($key !== 'age') { // 'age' is derived, not directly updated
                $setParts[] = "`{$key}` = :{$key}";
                $params[":{$key}"] = $value;
            }
        }
        // Always update 'updated_at' when any data is updated
        $setParts[] = "`updated_at` = NOW()";


        if (empty($setParts)) {
            return true; // No data to update
        }

        $sql = "UPDATE `" . $this->table_name . "` SET " . implode(', ', $setParts) . " WHERE `resident_id` = :resident_id";

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error updating resident: " . $e->getMessage());
            return false;
        }
    }

    public function updateResidentStatus($residentId, int $isBanned): bool
    {
        // Ensure isBanned is either 0 or 1
        $isBanned = ($isBanned == 1) ? 1 : 0;

        // CORRECTED: Update 'is_banned' column
        $query = "UPDATE " . $this->table_name . " SET is_banned = :is_banned, updated_at = NOW() WHERE resident_id = :resident_id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':is_banned', $isBanned, PDO::PARAM_INT);
            $stmt->bindParam(':resident_id', $residentId, PDO::PARAM_STR); // Bind as string since resident_id is VARCHAR
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating resident ban status: " . $e->getMessage());
            return false;
        }
    }
}