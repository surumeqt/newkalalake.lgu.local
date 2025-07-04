<?php
require_once __DIR__ . '/../config/database.config.php';

class GetRecordsModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    public function getAllCases() {
        $sql = "
            SELECT
                d.Document_ID,
                d.Docket_Case_Number,
                d.Document_Type,
                d.PDF_File,
                h.Hearing_Type,
                h.Hearing_Status
            FROM documents d
            INNER JOIN hearings h ON d.Docket_Case_Number = h.Docket_Case_Number
            WHERE d.Document_Type = 'Appeal'
            ORDER BY d.Document_ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCasesByHearingStatus($status) {
        $sql = "
            SELECT
                d.Document_ID,
                d.Docket_Case_Number,
                d.Document_Type,
                d.PDF_File,
                h.Hearing_Type,
                h.Hearing_Status
            FROM documents d
            INNER JOIN hearings h ON d.Docket_Case_Number = h.Docket_Case_Number
            WHERE d.Document_Type = 'Appeal' AND h.Hearing_Status = ?
            ORDER BY d.Document_ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingCases() {
        $sql = "
            SELECT
                d.Document_ID,
                d.Docket_Case_Number,
                d.Document_Type,
                d.PDF_File,
                h.Hearing_Type,
                h.Hearing_Status
            FROM documents d
            INNER JOIN hearings h ON d.Docket_Case_Number = h.Docket_Case_Number
            WHERE d.Document_Type = 'Appeal'
            AND h.Hearing_Status NOT IN ('Rehearing', 'Dismissed', 'Settled', 'CFA', 'Withdrawn')
            ORDER BY d.Document_ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}