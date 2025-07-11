<?php
require_once __DIR__ . '/../config/database.config.php';
require_once 'models/pdf.generator.model.php';

class UpdateStatusModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }

    public function updateStatus($docket, $newStatus) {
        if ($newStatus === 'Ongoing') {
            return $this->handleRehearingToOngoing($docket);
        }

        return $this->updateRegularStatus($docket, $newStatus);
    }

    private function updateRegularStatus($docket, $status) {
        $stmt = $this->conn->prepare("UPDATE hearings SET Hearing_Status = ? WHERE Docket_Case_Number = ?");
        return $stmt->execute([$status, $docket]);
    }

    private function handleRehearingToOngoing($docket) {
        $stmt = $this->conn->prepare("SELECT ID, Hearing_Type, Hearing_Status FROM hearings WHERE Docket_Case_Number = ? ORDER BY ID DESC LIMIT 1");
        $stmt->execute([$docket]);
        $latest = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$latest || $latest['Hearing_Status'] !== 'Rehearing') {
            return false;
        }

        $nextType = $this->getNextHearingType($latest['Hearing_Type']);

        $update = $this->conn->prepare("UPDATE hearings SET Hearing_Status = ?, Hearing_Type = ? WHERE ID = ?");
        return $update->execute(['Ongoing', $nextType, $latest['ID']]);
    }

    private function getNextHearingType($currentType) {
        preg_match('/^(\d+)[a-z]{2}/i', $currentType, $matches);
        $nextNum = isset($matches[1]) ? intval($matches[1]) + 1 : 2;

        // Proper ordinal suffix
        $suffix = match ($nextNum % 10) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th'
        };

        // Handle special cases (e.g., 11th, 12th, 13th)
        if (in_array($nextNum % 100, [11, 12, 13])) {
            $suffix = 'th';
        }

        return "{$nextNum}{$suffix} Hearing";
    }
    
    public function saveSummaryDocument($docketCaseNumber, $reportSummaryText, $hearingDate = null) {
        $stmt = $this->conn->prepare("SELECT * FROM cases WHERE Docket_Case_Number = ?");
        $stmt->execute([$docketCaseNumber]);
        $case = $stmt->fetch(PDO::FETCH_ASSOC);

        $hearingStmt = $this->conn->prepare("SELECT Hearing_Type, Hearing_Date, Hearing_Status FROM hearings WHERE Docket_Case_Number = ? ORDER BY ID DESC LIMIT 1");
        $hearingStmt->execute([$docketCaseNumber]);
        $hearing = $hearingStmt->fetch(PDO::FETCH_ASSOC);

        if ($hearingDate == null) {
            $hearingDate = $hearing['Hearing_Date'];
        }

        $case['report_summary_text'] = $reportSummaryText;

        $pdfGen = new PDFGenerator($case);
        $newPdfBlob = $pdfGen->GenerateSummaryBlob($hearingDate, $hearing['Hearing_Type']);

        $insertStmt = $this->conn->prepare("
            INSERT INTO summary (Docket_Case_Number, Hearing_Type, Hearing_Status, Document_Type, PDF_File, Created_At)
            VALUES (?, ?, ?, 'Summary', ?, NOW())
        ");
        $insertStmt->bindValue(1, $docketCaseNumber);
        $insertStmt->bindValue(2, $hearing['Hearing_Type']);
        $insertStmt->bindValue(3, $hearing['Hearing_Status']);
        $insertStmt->bindValue(4, $newPdfBlob, PDO::PARAM_LOB);
        return $insertStmt->execute();
    }
    public function RehearingAppealType($docketCaseNumber, $newHearingDate) {
        try {
            $this->conn->beginTransaction();

            $getFirstHearing = $this->conn->prepare("
                SELECT Hearing_Type 
                FROM hearings 
                WHERE Docket_Case_Number = ? 
                ORDER BY ID ASC 
                LIMIT 1
            ");
            $getFirstHearing->execute([$docketCaseNumber]);
            $firstHearing = $getFirstHearing->fetch(PDO::FETCH_ASSOC);

            if (!$firstHearing) {
                $this->conn->rollBack();
                return false;
            }

            $hearingType = $firstHearing['Hearing_Type'];

            $stmt = $this->conn->prepare("SELECT * FROM cases WHERE Docket_Case_Number = ?");
            $stmt->execute([$docketCaseNumber]);
            $case = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$case) {
                $this->conn->rollBack();
                return false;
            }

            $pdfGen = new PDFGenerator($case);
            $updatedPdfBlob = $pdfGen->generateCombinedNoticeAndSummonBlob($hearingType, $newHearingDate);

            $updateDoc = $this->conn->prepare("
                UPDATE documents 
                SET PDF_File = ?, Created_At = NOW()
                WHERE Docket_Case_Number = ? AND Document_Type = 'Appeal'
            ");
            $updateDoc->bindValue(1, $updatedPdfBlob, PDO::PARAM_LOB);
            $updateDoc->bindValue(2, $docketCaseNumber);
            $updateDoc->execute();

            $updateHearing = $this->conn->prepare("
                UPDATE hearings
                SET Hearing_Date = ?
                WHERE Docket_Case_Number = ?
                ORDER BY ID DESC
                LIMIT 1
            ");
            $updateHearing->execute([$newHearingDate, $docketCaseNumber]);

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("RehearingAppealType failed: " . $e->getMessage());
            return false;
        }
    }


}
