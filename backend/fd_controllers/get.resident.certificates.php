<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../models/certificate.model.php';

try {
    $certificateModel = new CertificateModel();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error initializing CertificateModel: ' . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resident_id'])) {
    $resident_id = filter_var($_POST['resident_id'], FILTER_VALIDATE_INT);

    if ($resident_id === false || $resident_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid Resident ID.']);
        exit();
    }

    try {
        $certificates = $certificateModel->residentIssuedCertificates($resident_id);
        echo json_encode(['success' => true, 'certificates' => $certificates]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching certificates: ' . $e->getMessage()]);
        exit();
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
