<?php
require_once './models/case.model.php';

$caseModel = new CaseEntry();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $docket = $_POST['doket_id'];

    $existingCase = $caseModel->getCaseByDocket($docket);

    $data = [
        'docket_case_number' => $docket,
        'case_title' => $_POST['case_title'],
        'complainant_name' => $_POST['complainant_name'],
        'complainant_address' => $_POST['complainant_address'],
        'respondent_name' => $_POST['respondent_name'],
        'respondent_address' => $_POST['respondent_address'],
    ];

    if (!$existingCase) {
        $caseModel->createCase($data);
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

    header("Location: ../upload.php?success=1&docket=$docket");
    exit;
}
