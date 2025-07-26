<?php
require_once __DIR__ . '/../config/database.config.php';

if (!isset($_GET['id'])) {
    die("No certificate ID provided.");
}

$certificateId = $_GET['id'];

$db = new Connection();
$pdo = $db->connect();

$stmt = $pdo->prepare("SELECT fileBlob FROM certificates WHERE id = ?");
$stmt->execute([$certificateId]);
$row = $stmt->fetch();

if (!$row || empty($row['fileBlob'])) {
    die("Certificate not found or no file.");
}

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=certificate_$certificateId.pdf");
echo $row['fileBlob'];
exit;
