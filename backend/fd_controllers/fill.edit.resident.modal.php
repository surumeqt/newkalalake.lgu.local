<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../models/resident.model.php';

$residentModel = new ResidentModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resident_id'])) {
    $resident_id = filter_var($_POST['resident_id'], FILTER_VALIDATE_INT);

    if ($resident_id === false || $resident_id <= 0) {
        echo json_encode(['found' => false, 'message' => 'Invalid Resident ID.']);
        exit();
    }

    $residentData = $residentModel->getResidentDetailsById($resident_id);

    if ($residentData) {
        $residentData['is_deceased'] = (bool)$residentData['is_deceased'];
        $residentData['father_is_deceased'] = (bool)$residentData['father_is_deceased'];
        $residentData['mother_is_deceased'] = (bool)$residentData['mother_is_deceased'];
        $residentData['have_a_business'] = (bool)$residentData['have_a_business'];

        echo json_encode([
            'found' => true,
            'data' => $residentData
        ]);
    } else {
        echo json_encode(['found' => false, 'message' => 'Resident not found.']);
    }
} else {
    echo json_encode(['found' => false, 'message' => 'Invalid request.']);
}
