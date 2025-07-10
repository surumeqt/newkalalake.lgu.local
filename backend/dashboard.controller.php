<?php
require_once '../config/database.config.php';

try {
    $db = new Connection();
    $conn = $db->connect();

    $totalStmt = $conn->prepare("SELECT COUNT(*) as total FROM cases");
    $totalStmt->execute();
    $totalCases = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    $pendingStmt = $conn->prepare("
        SELECT COUNT(*) as total 
        FROM hearings 
        WHERE Hearing_Status IN ('Ongoing', 'Rehearing')
    ");
    $pendingStmt->execute();
    $pendingCases = $pendingStmt->fetch(PDO::FETCH_ASSOC)['total'];

    function getCountByStatus($conn, $status) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM hearings WHERE Hearing_Status = ?");
        $stmt->execute([$status]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    $settledCases   = getCountByStatus($conn, 'Settled');
    $dismissedCases = getCountByStatus($conn, 'Dismissed');
    $withdrawnCases = getCountByStatus($conn, 'Withdrawn');
    $cfaCases       = getCountByStatus($conn, 'CFA');

    echo json_encode([
        'total_cases'     => $totalCases,
        'pending_cases'   => $pendingCases,
        'settled_cases'   => $settledCases,
        'dismissed_cases' => $dismissedCases,
        'withdrawn_cases' => $withdrawnCases,
        'cfa_cases'       => $cfaCases,
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
