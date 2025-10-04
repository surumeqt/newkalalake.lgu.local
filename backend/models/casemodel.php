<?php

namespace backend\models;

use backend\config\Connection;
use backend\models\pdfmodel;

class casemodel {
    private $db;
    private $caseId;

    public function __construct() {
        $this->db = Connection::getConnection();
        $this->caseId = $this->db->LastInsertId();
    }

    public function createCase($data){
         $sql = "INSERT INTO cases 
                (case_number, case_title, case_nature, complainant_name, complainant_address, respondent_name, respondent_address) 
                VALUES
                (:case_number, :case_title, :case_nature, :complainant_name, :complainant_address, :respondent_name, :respondent_address)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($data);
        if ($success) {
            $this->addHearing($data['hearing_time']);
            $this->createDocument($data);
            return true;
        } else {
            return false;
        }
    }
    private function addHearing($timeFiled){
        $sql = "INSERT INTO hearings (case_id, hearing_time) VALUES (:case_id, :hearing_time)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'case_id' => $this->caseId,
            'hearing_time' => $timeFiled
        ]);
    }
    private function createDocument($data){
        $pdf = new pdfmodel($data);
        $filename = $pdf->generateNoticeSummonFile();

        $sql = "INSERT INTO documents (case_id, document_path) VALUES (:case_id, :document_path)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'case_id' => $this->caseId,
            'document_path'   => $filename
        ]);
    }
    public function updateCase($data){}
    public function getCasesByStatus($status){}
    public function deleteCase($id){}
}