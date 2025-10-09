<?php

namespace backend\class;

class tohearings extends baseclass {
    public function insertData($data) {
        $sql = "INSERT INTO hearings (case_id, hearing_time, hearing_date)
                VALUES (:case_id, :hearing_time, :hearing_date)";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':case_id' => $data['case_id'],
                ':hearing_time' => $data['hearing_time'],
                ':hearing_date' => $data['hearing_date']
            ]);

            return $this->getLastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    public function updateStatus($caseId, $hearingStatus) {
        $sql = "UPDATE hearings SET hearing_status = :hearing_status WHERE case_id = :case_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':hearing_status' => $hearingStatus,
            ':case_id' => $caseId
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
        $stmt->execute([':hearing_status' => $hearingStatus]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
