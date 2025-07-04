<?php
require_once __DIR__ . '/../config/database.config.php';

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
        $stmt = $this->conn->prepare("SELECT Hearing_ID, Hearing_Type, Hearing_Status FROM hearings WHERE Docket_Case_Number = ? ORDER BY Hearing_ID DESC LIMIT 1");
        $stmt->execute([$docket]);
        $latest = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$latest || $latest['Hearing_Status'] !== 'Rehearing') {
            return false;
        }

        $nextType = $this->getNextHearingType($latest['Hearing_Type']);

        $update = $this->conn->prepare("UPDATE hearings SET Hearing_Status = ?, Hearing_Type = ? WHERE Hearing_ID = ?");
        return $update->execute(['Ongoing', $nextType, $latest['Hearing_ID']]);
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
}
