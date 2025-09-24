<?php

namespace backend\models;

use backend\config\Connection;

class casemodel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function createCase($data) {
        $stmt = $this->db->prepare(
    "INSERT INTO `case` (case_number, case_title, case_nature, complainant_name, complainant_address, respondent_name, respondent_address) 
            VALUES
            (:case_number, :case_title, :case_nature, :complainant_name, :complainant_address, :respondent_name, :respondent_address) ");
        $done = $stmt->execute([
            'case_number' => $data['case_number'],
            'case_title' => $data['case_title'],
            'case_nature' => $data['case_nature'],
            'complainant_name' => $data['complainant_name'],
            'complainant_address' => $data['complainant_address'],
            'respondent_name' => $data['respondent_name'],
            'respondent_address' => $data['respondent_address']
        ]);

        if ($done) {
            $caseId = $this->db->lastInsertId();
            return $this->addhearing($data['time_filed'], $caseId);
        } else {
            return false;
        }
    }

    private function addhearing($timeFiled, $caseId) {
        $stmt = $this->db->prepare(
            "INSERT INTO hearing (case_id, hearing_time) VALUES (:case_id, :hearing_time)"
        );
        return $stmt->execute([
            'case_id' => $caseId,
            'hearing_time' => $timeFiled
        ]);
    }
    
    public function getCasesByStatus() {
        $sql = "SELECT 
            c.case_id, 
            c.case_number, 
            c.complainant_name, 
            c.respondent_name, 
            h.hearing_status
        FROM `case` c
        JOIN hearing h ON c.case_id = h.case_id
        WHERE h.hearing_status = 'Ongoing'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}