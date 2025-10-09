<?php

namespace backend\class;

use backend\models\pdfmodel;

class todocuments extends baseclass {
    public function insertData($data) {
        $pdf = new pdfmodel($data);
        $filename = $pdf->generateNoticeSummonFile();

        $sql = "INSERT INTO documents (case_id, document_path)
                VALUES (:case_id, :document_path)";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':case_id' => $data['case_id'],
                ':document_path' => $filename
            ]);

            return $this->getLastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
}