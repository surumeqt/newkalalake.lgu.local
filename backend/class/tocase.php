<?php

namespace backend\class;

class tocase extends baseclass {
    public function insertData($data) {
        $sql =
        "INSERT INTO cases
        (case_number, case_title, case_nature, complainant_name, complainant_address, respondent_name, respondent_address) 
        VALUES
        (:case_number, :case_title, :case_nature, :complainant_name, :complainant_address, :respondent_name, :respondent_address)";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':case_number' => $data['case_number'],
                ':case_title' => $data['case_title'],
                ':case_nature' => $data['case_nature'],
                ':complainant_name' => $data['complainant_name'],
                ':complainant_address' => $data['complainant_address'],
                ':respondent_name' => $data['respondent_name'],
                ':respondent_address' => $data['respondent_address']
            ]);
            return $this->getLastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    public function findById($caseId) {
        $sql = "SELECT * FROM cases WHERE case_id = :case_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':case_id' => $caseId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function deleteCaseById($caseId) {
        $sql = "DELETE FROM cases WHERE case_id = :case_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':case_id' => $caseId]);
    }
}