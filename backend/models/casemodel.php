<?php

namespace backend\models;

use backend\config\Connection;
use backend\models\pdfmodel;

class casemodel {
    private $db;
    private $caseId;
    public function __construct() {
        $this->db = Connection::getConnection();
    }
  
    public function createCase($data) {
        $stmt = $this->db->prepare(
    "INSERT INTO cases (case_number, case_title, case_nature, complainant_name, complainant_address, respondent_name, respondent_address) 
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
            $this->caseId = $this->db->lastInsertId();
            $this->addhearing($data['time_filed'], $data['date_filed']);
            $this->createdocument($data);
            return true;
        } else {
            return false;
        }
    }

    private function addhearing($time, $date) {
        $stmt = $this->db->prepare(
            "INSERT INTO hearings (case_id, hearing_time, hearing_date) VALUES (:case_id, :hearing_time, :hearing_date)"
        );
        return $stmt->execute([
            'case_id' => $this->caseId,
            'hearing_time' => $time,
            'hearing_date' => $date
        ]);
    }

    private function createdocument($data){
        $pdf = new pdfmodel($data);
        $filename = $pdf->generateNoticeSummonFile();

        $stmt = $this->db->prepare(
            "INSERT INTO documents (case_id, document_path) VALUES (:case_id, :document_path)"
        );
        $stmt->execute([
            'case_id' => $this->caseId,
            'document_path'   => $filename
        ]);
    }
    
    public function getCasesByStatus($hearingStatus) {
        $sql = "SELECT 
                    c.case_id,
                    c.case_title,
                    c.case_number,
                    c.complainant_name,
                    c.respondent_name,
                    h.hearing_status,
                    d.document_path
                FROM cases c
                JOIN hearings h ON c.case_id = h.case_id
                LEFT JOIN documents d ON c.case_id = d.case_id
                WHERE h.hearing_status = :hearing_status";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'hearing_status' => $hearingStatus
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($caseId) {
        $sql = " SELECT case_id from cases where case_id = :case_id ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['case_id' => $caseId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function updateStatus($caseId, $hearingStatus) {
        $sql = "UPDATE hearings SET hearing_status = :hearing_status WHERE case_id = :case_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'hearing_status' => $hearingStatus,
            'case_id' => $caseId
        ]);
    }
    public function deleteCaseById($caseId) {
        $sql = "DELETE FROM cases WHERE case_id = :case_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['case_id' => $caseId]);
    }
}