<?php
header('Content-Type: application/json');

require_once './models/case.model.php';

$json_data = file_get_contents('php://input');

$data = json_decode($json_data, true);

if (isset($data['docket'])) {
    $docket = $data['docket'];
    $model = new CaseEntry();
    
    $result = $model->deleteCaseAndSummary($docket);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Record and summary deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete record. Please check the server logs.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request. Docket number not provided.']);
}