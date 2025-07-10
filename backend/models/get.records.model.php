<?php
require_once __DIR__ . '/../config/database.config.php';

class GetRecordsModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    private function baseQuery() {
        return "
            SELECT
                d.ID,
                d.Docket_Case_Number,
                d.Document_Type,
                d.PDF_File,
                h.Hearing_Type,
                h.Hearing_Status,
                c.Case_Title,
                c.Complainant_Name,
                c.Respondent_Name,
                d.Created_At
            FROM documents d
            INNER JOIN hearings h ON d.Docket_Case_Number = h.Docket_Case_Number
            INNER JOIN cases c ON d.Docket_Case_Number = c.Docket_Case_Number
        ";
    }

    public function getSummaryHistory($limit = 10) {
        $sql = "
            SELECT 
                s.ID,
                s.Docket_Case_Number,
                s.Hearing_Type,
                s.Hearing_Status,
                s.Document_Type,
                s.Created_At,
                c.Case_Title,
                c.Complainant_Name, 
                c.Respondent_Name
            FROM summary s
            INNER JOIN cases c ON s.Docket_Case_Number = c.Docket_Case_Number
            ORDER BY s.ID DESC
            LIMIT ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCasesByHearingStatus($status) {
        $sql = $this->baseQuery() . "
            WHERE d.Document_Type = 'Appeal' AND h.Hearing_Status = ?
            ORDER BY d.ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingCases() {
        $sql = $this->baseQuery() . "
            WHERE d.Document_Type = 'Appeal'
              AND h.Hearing_Status NOT IN ('Rehearing', 'Dismissed', 'Settled', 'CFA', 'Withdrawn')
            ORDER BY d.ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterSummaryByStatus($status) {
        $sql = "
            SELECT 
                s.ID,
                s.Docket_Case_Number,
                s.Hearing_Type,
                s.Hearing_Status,
                s.Document_Type,
                s.PDF_File,
                s.Created_At,
                c.Case_Title,
                c.Complainant_Name,
                c.Respondent_Name
            FROM summary s
            INNER JOIN cases c ON s.Docket_Case_Number = c.Docket_Case_Number
            WHERE s.Hearing_Status = ?
            ORDER BY s.ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterSummaryByDocketNumber($docketNumber) {
        $sql = "
            SELECT 
                s.ID,
                s.Docket_Case_Number,
                s.Hearing_Type,
                s.Hearing_Status,
                s.Document_Type,
                s.PDF_File,
                s.Created_At,
                c.Case_Title,
                c.Complainant_Name,
                c.Respondent_Name
            FROM summary s
            INNER JOIN cases c ON s.Docket_Case_Number = c.Docket_Case_Number
            WHERE s.Docket_Case_Number LIKE ?
            ORDER BY s.ID DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['%' . $docketNumber . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
