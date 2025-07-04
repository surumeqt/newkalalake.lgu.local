<?php
require_once './models/get.records.model.php';
require_once './config/database.config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit("Invalid request");
}

$docId = $_GET['id'];
$db = new Connection();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT PDF_File FROM documents WHERE Document_ID = ?");
$stmt->execute([$docId]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && $row['PDF_File']) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="document.pdf"');
    echo $row['PDF_File'];
} else {
    http_response_code(404);
    echo "PDF not found.";
}
