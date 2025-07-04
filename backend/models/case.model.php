<?php
require_once __DIR__ . '/../config/database.config.php';
require_once 'models/pdf.generator.model.php';

class CaseEntry {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    public function createCase($data) {
        $sql = "INSERT INTO cases (
                    Docket_Case_Number,
                    Case_Title,
                    Complainant_Name,
                    Complainant_Address,
                    Respondent_Name,
                    Respondent_Address,
                    Created_At
                ) VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['docket_case_number'],
            $data['case_title'],
            $data['complainant_name'],
            $data['complainant_address'],
            $data['respondent_name'],
            $data['respondent_address']
        ]);
    }

    public function addHearing($data) {
        $sql = "INSERT INTO hearings (
                    Docket_Case_Number,
                    Hearing_Type,
                    Hearing_Date,
                    Hearing_Status
                ) VALUES (?, ?, ?, 'Ongoing')";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['docket_case_number'],
            $data['hearing_type'],
            $data['hearing_date']
        ]);
    }

    public function saveAppealDocument($data) {
        // Generate the PDF
        $pdfGen = new PDFGenerator($data);
        $pdfBlob = $pdfGen->generateCombinedNoticeAndSummonBlob($data['hearing_type'], $data['hearing_date']);

        // Insert into documents table
        $sql = "INSERT INTO documents (
                    Docket_Case_Number,
                    Document_Type,
                    PDF_File,
                    Created_At
                ) VALUES (?, 'Appeal', ?, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $data['docket_case_number']);
        $stmt->bindValue(2, $pdfBlob, PDO::PARAM_LOB);
        $stmt->execute();
    }
}
