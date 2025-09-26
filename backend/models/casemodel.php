<?php

namespace backend\models;

use backend\config\Connection;
use backend\models\pdfmodel;

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
            $this->addhearing($data['time_filed'], $caseId);
            $this->createdocument($data, $caseId);
            return true;
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

    private function createdocument($data, $caseId){
        $pdf = new pdfmodel($data);
        $filename = $pdf->firsthearing();

        $stmt = $this->db->prepare(
            "INSERT INTO document_details (case_id, document_path) VALUES (:case_id, :document_path)"
        );
        $stmt->execute([
            'case_id' => $caseId,
            'document_path'   => $filename
        ]);
    }
    
    public function getCasesByStatus() {
        $sql = "SELECT 
                    c.case_id,
                    c.case_title,
                    c.case_number,
                    c.complainant_name,
                    c.respondent_name,
                    h.hearing_status,
                    d.document_path
                FROM `case` c
                JOIN hearing h ON c.case_id = h.case_id
                LEFT JOIN document_details d ON c.case_id = d.case_id
                WHERE h.hearing_status = 'Ongoing'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}