<?php
require_once './models/case.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case = new CaseEntry();

    $formData = [
        'docket_case_number' => date('d-m-y', strtotime($_POST['docket_case_number'])),
        'case_title' => $_POST['case_title'],
        'complainant_name' => $_POST['complainant_name'],
        'complainant_address' => $_POST['complainant_address'],
        'respondent_name' => $_POST['respondent_name'],
        'respondent_address' => $_POST['respondent_address'],
        'hearing_type' => $_POST['hearing_type'],
        'hearing_date' => $_POST['hearing_date'],
    ];

    try {
        $case->createCase($formData);
        $case->addHearing($formData);
        $case->saveAppealDocument($formData);
        header("Location: ../app/app.php?entry=success");
        exit();
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
