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
                    Case_Type
                ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['docket_case_number'],
            $data['case_title'],
            $data['complainant_name'],
            $data['complainant_address'],
            $data['respondent_name'],
            $data['respondent_address'],
            $data['case_type']
        ]);
    }
    public function encodeOldCases($data){
        $sql = "INSERT INTO cases (
            Docket_Case_Number,
            Case_Title,
            Complainant_Name,
            Complainant_Address,
            Respondent_Name,
            Respondent_Address,
            Case_Type
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['docket_case_number'],
            $data['case_title'],
            $data['complainant_name'],
            $data['complainant_address'],
            $data['respondent_name'],
            $data['respondent_address'],
            $data['case_type']
        ]);

        $sql2 = "INSERT INTO hearings (
                    Docket_Case_Number,
                    Hearing_Type,
                    Hearing_Date,
                    Hearing_Status,
                    Hearing_Time,
                    Time_Period
                ) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([
            $data['docket_case_number'],
            $data['hearing_type'],
            $data['hearing_date'],
            $data['hearing_status'],
            $data['hearing_time'],
            $data['iat']
        ]);

        $sql3 = "INSERT INTO summary (
                    Docket_Case_Number,
                    Hearing_Type,
                    Hearing_Status,
                    Document_Type
                ) VALUES (?, ?, ?, 'Summary')";
        $stmt3 = $this->conn->prepare($sql3);
        $stmt3->bindValue(1, $data['docket_case_number']);
        $stmt3->bindValue(2, $data['hearing_type']);
        $stmt3->bindValue(3, $data['hearing_status']);
        $stmt3->execute();
    }
    
    public function addHearing($data) {
        $sql = "INSERT INTO hearings (
                    Docket_Case_Number,
                    Hearing_Type,
                    Hearing_Date,
                    Hearing_Time,
                    Time_Period
                ) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['docket_case_number'],
            $data['hearing_type'],
            $data['hearing_date'],
            $data['hearing_time'],
            $data['iat']
        ]);
    }

    public function saveAppealDocument($data) {
        $hearingTypes = [$data['hearing_type']];
        $hearingDates = [$data['hearing_date']];

        $pdfGen = new PDFGenerator($data);
        $pdfBlob = $pdfGen->generateCombinedNoticeAndSummonBlob(
            $hearingTypes,
            $hearingDates,
            $data['hearing_type'],
            $data['hearing_date'],
            $data['hearing_time'],
            $data['iat']
        );

        $sql = "INSERT INTO documents (
                    Docket_Case_Number,
                    Document_Type,
                    PDF_File
                ) VALUES (?, 'Appeal', ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $data['docket_case_number']);
        $stmt->bindValue(2, $pdfBlob, PDO::PARAM_LOB);
        $stmt->execute();
    }

    public function insertFilesToCase($docket, $newFilesJson) {
        $stmt = $this->conn->prepare("SELECT filesUploaded FROM cases WHERE Docket_Case_Number = ?");
        $stmt->execute([$docket]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $currentFiles = [];

        if ($row && !empty($row['filesUploaded'])) {
            $currentFiles = json_decode($row['filesUploaded'], true);
        }

        $newFiles = json_decode($newFilesJson, true);

        if (is_array($newFiles)) {
            $mergedFiles = array_merge($currentFiles, $newFiles);
        } else {
            $mergedFiles = $currentFiles;
        }

        $finalJson = json_encode($mergedFiles);
        $updateStmt = $this->conn->prepare("UPDATE cases SET filesUploaded = ? WHERE Docket_Case_Number = ?");
        $updateStmt->bindValue(1, $finalJson, PDO::PARAM_STR);
        $updateStmt->bindValue(2, $docket);

        return $updateStmt->execute();
    }


    public function getCaseByDocket($docket) {
        $sql = "SELECT * FROM cases WHERE Docket_Case_Number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$docket]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getCaseWithHearing($docket) {
        $sql = "SELECT * FROM cases WHERE Docket_Case_Number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$docket]);
        $case = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($case) {
            $hearingSql = "SELECT Hearing_Type, Hearing_Status, Hearing_Date , Hearing_Time, Time_Period FROM hearings WHERE Docket_Case_Number = ? ORDER BY ID DESC LIMIT 1";
            $hearingStmt = $this->conn->prepare($hearingSql);
            $hearingStmt->execute([$docket]);
            $hearing = $hearingStmt->fetch(PDO::FETCH_ASSOC);

            if ($hearing) {
                $case['Hearing_Date'] = $hearing['Hearing_Date'];
                $case['Hearing_Type'] = $hearing['Hearing_Type'];
                $case['Hearing_Status'] = $hearing['Hearing_Status'];
                $case['Hearing_Time'] = $hearing['Hearing_Time'];
                $case['Time_Period'] = $hearing['Time_Period'];
            }
        }

        return $case;
    }
    public function getCaseFiles($docket) {
        $sql = "SELECT filesUploaded FROM `cases` WHERE Docket_Case_Number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$docket]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row['filesUploaded']) && !empty($row['filesUploaded'])) {
            return $row['filesUploaded'];
        }
        return null;
    }
    public function deleteCaseAndSummary($docket) {
        try {
            $this->conn->beginTransaction();

            $sql_cases = "DELETE FROM cases WHERE Docket_Case_Number = ?";
            $stmt_cases = $this->conn->prepare($sql_cases);
            $stmt_cases->execute([$docket]);

            $sql_summary = "DELETE FROM summary WHERE Docket_Case_Number = ?";
            $stmt_summary = $this->conn->prepare($sql_summary);
            $stmt_summary->execute([$docket]);

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Deletion failed: " . $e->getMessage());
            return false;
        }
    }
}