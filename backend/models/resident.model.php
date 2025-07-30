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
            father_first_name, father_middle_name, father_last_name, father_suffix,
            father_birth_date, father_is_deceased, father_deceased_date, father_occupation,
            father_educational_attainment, father_contact_no,
            mother_first_name, mother_middle_name, mother_last_name, mother_suffix,
            mother_birth_date, mother_is_deceased, mother_deceased_date, mother_occupation,
            mother_educational_attainment, mother_contact_no
        ) VALUES (
            :resident_id, :is_deceased, :deceased_date, :occupation, :educational_attainment,
            :father_first_name, :father_middle_name, :father_last_name, :father_suffix,
            :father_birth_date, :father_is_deceased, :father_deceased_date, :father_occupation,
            :father_educational_attainment, :father_contact_no,
            :mother_first_name, :mother_middle_name, :mother_last_name, :mother_suffix,
            :mother_birth_date, :mother_is_deceased, :mother_deceased_date, :mother_occupation,
            :mother_educational_attainment, :mother_contact_no
        )";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':resident_id' => $resident_id,
            ':is_deceased' => $data['is_deceased'],
            ':deceased_date' => $data['deceased_date'],
            ':occupation' => $data['occupation'],
            ':educational_attainment' => $data['educational_attainment'],
            ':father_first_name' => $data['father_first_name'],
            ':father_middle_name' => $data['father_middle_name'],
            ':father_last_name' => $data['father_last_name'],
            ':father_suffix' => $data['father_suffix'],
            ':father_birth_date' => $data['father_birth_date'],
            ':father_is_deceased' => $data['father_is_deceased'],
            ':father_deceased_date' => $data['father_deceased_date'],
            ':father_occupation' => $data['father_occupation'],
            ':father_educational_attainment' => $data['father_educational_attainment'],
            ':father_contact_no' => $data['father_contact_no'],
            ':mother_first_name' => $data['mother_first_name'],
            ':mother_middle_name' => $data['mother_middle_name'],
            ':mother_last_name' => $data['mother_last_name'],
            ':mother_suffix' => $data['mother_suffix'],
            ':mother_birth_date' => $data['mother_birth_date'],
            ':mother_is_deceased' => $data['mother_is_deceased'],
            ':mother_deceased_date' => $data['mother_deceased_date'],
            ':mother_occupation' => $data['mother_occupation'],
            ':mother_educational_attainment' => $data['mother_educational_attainment'],
            ':mother_contact_no' => $data['mother_contact_no']
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
    private function getResidentById($resident_id) {
        $stmt = $this->conn->prepare("SELECT * FROM residents WHERE resident_id = ?");
        $stmt->execute([$resident_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    private function getAddedInfoById($resident_id) {
        $stmt = $this->conn->prepare("SELECT * FROM residents_added_info WHERE resident_id = ?");
        $stmt->execute([$resident_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}