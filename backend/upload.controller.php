<?php
require_once './models/case.model.php';

$caseModel = new CaseEntry();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['docket_lookup'])) {
        $docket = $_POST['docket_lookup'];

        $existingCase = $caseModel->getCaseWithHearing($docket); 

        if ($existingCase) {
            echo json_encode([
                'success' => true,
                'data' => $existingCase
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No case found for Docket ID.'
            ]);
        }
        exit;
    }

    $docket = $_POST['doket_id'];
    $existingCase = $caseModel->getCaseByDocket($docket);

    $data = [
        'docket_case_number' => $docket,
        'case_title' => $_POST['case_title'],
        'complainant_name' => $_POST['complainant_name'],
        'complainant_address' => $_POST['complainant_address'],
        'respondent_name' => $_POST['respondent_name'],
        'respondent_address' => $_POST['respondent_address'],
        'case_type' => $_POST['case_type'],
        'hearing_type' => $_POST['hearing_type'],
        'hearing_date' => $_POST['hearing_date'],
        'hearing_status' => $_POST['hearing_status'],
        'hearing_time' => $_POST['hours'],
        'iat' => $_POST['iat'],
    ];

    if (!$existingCase) {
        $caseModel->encodeOldCases($data);
    }

    $fileBlobs = [];
    foreach ($_FILES['file_upload']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['file_upload']['error'][$index] === UPLOAD_ERR_OK) {
            $filedata = file_get_contents($tmpName);
            $fileBlobs[] = base64_encode($filedata);
        }
    }

    if (!empty($fileBlobs)) {
        $encodedBlobs = json_encode($fileBlobs);
        $caseModel->insertFilesToCase($docket, $encodedBlobs);
    }

    header("Location: ../app/app.php?status=success");
    exit;
}
