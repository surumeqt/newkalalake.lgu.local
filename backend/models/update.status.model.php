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

        $suffix = match ($nextNum % 10) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th'
        };

        if (in_array($nextNum % 100, [11, 12, 13])) {
            $suffix = 'th';
        }

        return "{$nextNum}{$suffix} Hearing";
    }
        
    public function saveSummaryDocument($docketCaseNumber, $reportSummaryText, $hearingDate = null) {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("SELECT * FROM cases WHERE Docket_Case_Number = ?");
            $stmt->execute([$docketCaseNumber]);
            $case = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$case) {
                $this->conn->rollBack();
                return false;
            }

            $hearingStmt = $this->conn->prepare("SELECT * FROM hearings WHERE Docket_Case_Number = ?");
            $hearingStmt->execute([$docketCaseNumber]);
            $hearing = $hearingStmt->fetch(PDO::FETCH_ASSOC);
            if (!$hearing) {
                $this->conn->rollBack();
                return false;
            }

            if ($hearingDate == null) {
                $hearingDate = $hearing['Hearing_Date'];
            }

            $historyQuery = $this->conn->prepare("
                SELECT Hearing_Type, Hearing_Date 
                FROM summary 
                WHERE Docket_Case_Number = ? 
                AND Document_Type = 'Summary'
                ORDER BY ID ASC
            ");
            $historyQuery->execute([$docketCaseNumber]);

            $hearingTypes = [];
            $hearingDates = [];

            while ($row = $historyQuery->fetch(PDO::FETCH_ASSOC)) {
                $hearingTypes[] = $row['Hearing_Type'];
                $hearingDates[] = $row['Hearing_Date'];
            }

            $hearingTypes[] = $hearing['Hearing_Type'];
            $hearingDates[] = $hearingDate;

            $case['report_summary_text'] = $reportSummaryText;
            $pdfGen = new PDFGenerator($case);
            $newPdfBlob = $pdfGen->GenerateSummaryBlob(
                $hearingTypes,
                $hearingDates,
                $hearingDate,
                $hearing['Hearing_Type'],
                $hearing['Hearing_Time'],
                $hearing['Time_Period']
            );

            $insertStmt = $this->conn->prepare("
                INSERT INTO summary (
                    Docket_Case_Number,
                    Hearing_Type,
                    Hearing_Status,
                    Hearing_Date,
                    Document_Type,
                    PDF_File
                ) VALUES (?, ?, ?, ?, 'Summary', ?)
            ");
            $insertStmt->bindValue(1, $docketCaseNumber);
            $insertStmt->bindValue(2, $hearing['Hearing_Type']);
            $insertStmt->bindValue(3, $hearing['Hearing_Status']);
            $insertStmt->bindValue(4, $hearingDate);
            $insertStmt->bindValue(5, $newPdfBlob, PDO::PARAM_LOB);
            $insertStmt->execute();

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("saveSummaryDocument failed: " . $e->getMessage());
            return false;
        }
    }

    public function RehearingAppealType($docketCaseNumber, $newHearingDate, $newHearingTime = null, $newTimePeriod = null) {
        try {
            $this->conn->beginTransaction();

            $updateHearing = $this->conn->prepare("
                UPDATE hearings
                SET Hearing_Date = ?, Hearing_Time = ?, Time_Period = ?
                WHERE Docket_Case_Number = ?
                ORDER BY ID DESC
                LIMIT 1
            ");
            $updateHearing->execute([$newHearingDate, $newHearingTime, $newTimePeriod, $docketCaseNumber]);

            $getHearingType = $this->conn->prepare("
                SELECT Hearing_Type 
                FROM hearings 
                WHERE Docket_Case_Number = ? 
                ORDER BY ID DESC 
                LIMIT 1
            ");
            $getHearingType->execute([$docketCaseNumber]);
            $latestHearing = $getHearingType->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->conn->prepare("SELECT * FROM cases WHERE Docket_Case_Number = ?");
            $stmt->execute([$docketCaseNumber]);
            $case = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$case) {
                $this->conn->rollBack();
                return false;
            }

            $historyQuery = $this->conn->prepare("
                SELECT Hearing_Type, Hearing_Date 
                FROM summary 
                WHERE Docket_Case_Number = ? 
                ORDER BY ID ASC
            ");
            $historyQuery->execute([$docketCaseNumber]);

            $hearingTypes = [];
            $hearingDates = [];
            while ($row = $historyQuery->fetch(PDO::FETCH_ASSOC)) {
                $hearingTypes[] = $row['Hearing_Type'];
                $hearingDates[] = $row['Hearing_Date'];
            }

            $hearingTypes[] = $latestHearing['Hearing_Type'];
            $hearingDates[] = $newHearingDate;

            $pdfGen = new PDFGenerator($case);
            $newPdfBlob = $pdfGen->generateCombinedNoticeAndSummonBlob(
                $hearingTypes,
                $hearingDates,
                $latestHearing['Hearing_Type'],
                $newHearingDate,
                $newHearingTime,
                $newTimePeriod
            );

            $updateDoc = $this->conn->prepare("
                UPDATE documents 
                SET PDF_File = ?, Created_At = NOW()
                WHERE Docket_Case_Number = ? AND Document_Type = 'Appeal'
            ");
            $updateDoc->bindValue(1, $newPdfBlob, PDO::PARAM_LOB);
            $updateDoc->bindValue(2, $docketCaseNumber);
            $updateDoc->execute();


            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("RehearingAppealType failed: " . $e->getMessage());
            return false;
        }
    }
}
