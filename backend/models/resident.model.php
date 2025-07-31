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
            contact_number, email, photo
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?
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
            $data['email'],
            $data['fileBlob']
        ]);
    }
    public function insertAddedInfo($resident_id, $data) {
        $sql = "INSERT INTO residents_added_info (
            resident_id, is_deceased, deceased_date, occupation, educational_attainment,
            job_title, monthly_income,
            father_first_name, father_middle_name, father_last_name, father_suffix,
            father_birth_date, father_age, father_is_deceased, father_deceased_date, father_occupation,
            father_educational_attainment, father_contact_no,
            mother_first_name, mother_middle_name, mother_last_name, mother_suffix,
            mother_birth_date, mother_age, mother_is_deceased, mother_deceased_date, mother_occupation,
            mother_educational_attainment, mother_contact_no,
            emergency_contact_name, emergency_contact_relationship, emergency_contact_no,
            have_a_business, business_name, business_address,
            num_brothers, num_sisters, order_of_birth
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?
        )";

        $stmt = $this->conn->prepare($sql);

        $values = [
            $resident_id,
            $data['is_deceased'] ?? null,
            $data['deceased_date'] ?? null,
            $data['occupation'] ?? null,
            $data['educational_attainment'] ?? null,
            $data['job_title'] ?? null,
            $data['monthly_income'] ?? null,

            // Father's info
            $data['father_first_name'] ?? null,
            $data['father_middle_name'] ?? null,
            $data['father_last_name'] ?? null,
            $data['father_suffix'] ?? null,
            $data['father_birth_date'] ?? null,
            $data['father_age'] ?? null, // New
            $data['father_is_deceased'] ?? null,
            $data['father_deceased_date'] ?? null,
            $data['father_occupation'] ?? null,
            $data['father_educational_attainment'] ?? null,
            $data['father_contact_no'] ?? null,

            // Mother's info
            $data['mother_first_name'] ?? null,
            $data['mother_middle_name'] ?? null,
            $data['mother_last_name'] ?? null,
            $data['mother_suffix'] ?? null,
            $data['mother_birth_date'] ?? null,
            $data['mother_age'] ?? null, // New
            $data['mother_is_deceased'] ?? null,
            $data['mother_deceased_date'] ?? null,
            $data['mother_occupation'] ?? null,
            $data['mother_educational_attainment'] ?? null,
            $data['mother_contact_no'] ?? null,

            // Emergency Contact Info
            $data['emergency_contact_name'] ?? null,
            $data['emergency_contact_relationship'] ?? null,
            $data['emergency_contact_no'] ?? null,

            // Business Info
            $data['have_a_business'] ?? null,
            $data['business_name'] ?? null,
            $data['business_address'] ?? null,

            // Siblings Info
            $data['num_brothers'] ?? null,
            $data['num_sisters'] ?? null,
            $data['order_of_birth'] ?? null
        ];

        return $stmt->execute($values);
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
        $query = "SELECT * FROM residents WHERE 
            TRIM(
                CONCAT_WS(' ',
                    first_name,
                    NULLIF(TRIM(middle_name), ''),
                    last_name,
                    NULLIF(TRIM(suffix), '')
                )
            ) = :name
            LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getResidentDetailsById($residentId) {
        $query = "SELECT
            r.resident_id,
            r.first_name,
            r.middle_name,
            r.last_name,
            r.suffix,
            r.birthday,
            r.age,
            r.gender,
            r.civil_status,
            r.address,
            r.contact_number,
            r.email,
            r.photo,
            r.created_at AS resident_registered_at, -- Alias to avoid conflict

            rai.update_id,
            rai.is_deceased,
            rai.deceased_date,
            rai.occupation,
            rai.educational_attainment,
            rai.job_title,
            rai.monthly_income,
            rai.father_first_name,
            rai.father_middle_name,
            rai.father_last_name,
            rai.father_suffix,
            rai.father_birth_date,
            rai.father_age,
            rai.father_is_deceased,
            rai.father_deceased_date,
            rai.father_occupation,
            rai.father_educational_attainment,
            rai.father_contact_no,
            rai.mother_first_name,
            rai.mother_middle_name,
            rai.mother_last_name,
            rai.mother_suffix,
            rai.mother_birth_date,
            rai.mother_age,
            rai.mother_is_deceased,
            rai.mother_deceased_date,
            rai.mother_occupation,
            rai.mother_educational_attainment,
            rai.mother_contact_no,
            rai.emergency_contact_name,
            rai.emergency_contact_relationship,
            rai.emergency_contact_no,
            rai.have_a_business,
            rai.business_name,
            rai.business_address,
            rai.num_brothers,
            rai.num_sisters,
            rai.order_of_birth,
            rai.status,
            rai.created_at AS added_info_last_updated -- Alias to avoid conflict
        FROM
            residents AS r
        LEFT JOIN
            residents_added_info AS rai ON r.resident_id = rai.resident_id
        WHERE
            r.resident_id = ?
        LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $residentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getTotalResidents() {
        $query = "SELECT COUNT(resident_id) AS total_residents FROM residents";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_residents'] ?? 0;
    }
    public function getResidentsRegisteredToday() {
        $today = date('Y-m-d');
        $query = "SELECT COUNT(resident_id) AS residents_today FROM residents WHERE DATE(created_at) = ?";
        $stmt = $this->conn->prepare(query: $query);
        $stmt->execute([$today]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['residents_today'] ?? 0;
    }
    public function getGenderDistribution() {
        $query = "SELECT gender, COUNT(resident_id) AS count FROM residents GROUP BY gender";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $distribution = ['Male' => 0, 'Female' => 0];
        foreach ($results as $row) {
            if (isset($distribution[$row['gender']])) {
                $distribution[$row['gender']] = (int)$row['count'];
            }
        }
        return $distribution;
    }
    public function getAgeGroupDistribution() {
        $query = "SELECT
                    SUM(CASE WHEN age BETWEEN 0 AND 17 THEN 1 ELSE 0 END) AS age_0_17,
                    SUM(CASE WHEN age BETWEEN 18 AND 35 THEN 1 ELSE 0 END) AS age_18_35,
                    SUM(CASE WHEN age BETWEEN 36 AND 60 THEN 1 ELSE 0 END) AS age_36_60,
                    SUM(CASE WHEN age > 60 THEN 1 ELSE 0 END) AS age_60_plus
                  FROM residents";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            '0-17' => (int)($result['age_0_17'] ?? 0),
            '18-35' => (int)($result['age_18_35'] ?? 0),
            '36-60' => (int)($result['age_36_60'] ?? 0),
            '60+' => (int)($result['age_60_plus'] ?? 0)
        ];
    }
    public function getRecentResidentActivities($limit = 7) {
        $query = "SELECT
                      created_at AS activity_date,
                      CONCAT(first_name, ' ', last_name) AS resident_name,
                      'registered' AS activity_type
                  FROM
                      residents
                  ORDER BY
                      created_at DESC
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}