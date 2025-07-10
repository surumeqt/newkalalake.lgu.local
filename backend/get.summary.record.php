<?php
require_once './config/database.config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit("Invalid request.");
}

$db = new Connection();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT PDF_File FROM summary WHERE ID = ?");
$stmt->execute([$_GET['id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && $row['PDF_File']) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="summary.pdf"');
    echo $row['PDF_File'];
} else {
    http_response_code(404);
    echo "PDF not found.";
}
