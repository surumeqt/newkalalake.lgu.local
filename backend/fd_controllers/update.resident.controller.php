<?php
require_once __DIR__ . '/../models/resident.model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $resident_id = $_POST['resident_id'] ?? null;

    if (!$resident_id) {
        die("Resident ID is required.");
    }

    $data = [
        'is_deceased' => $_POST['editIsDeceased'] === 'true' ? 1 : 0,
        'deceased_date' => $_POST['editDeceasedDate'] ?? null,
        'occupation' => $_POST['editOccupation'] ?? null,
        'educational_attainment' => $_POST['editEducationalAttainment'] ?? null,

        'father_first_name' => $_POST['editFatherFirstName'] ?? null,
        'father_middle_name' => $_POST['editFatherMiddleName'] ?? null,
        'father_last_name' => $_POST['editFatherLastName'] ?? null,
        'father_suffix' => $_POST['editFatherSuffix'] ?? null,
        'father_birth_date' => $_POST['editFatherBirthDate'] ?? null,
        'father_is_deceased' => $_POST['editFatherIsDeceased'] === 'true' ? 1 : 0,
        'father_deceased_date' => $_POST['editFatherDeceasedDate'] ?? null,
        'father_occupation' => $_POST['editFatherOccupation'] ?? null,
        'father_educational_attainment' => $_POST['editFatherEducationalAttainment'] ?? null,
        'father_contact_no' => $_POST['editFatherContactNo'] ?? null,

        'mother_first_name' => $_POST['editMotherFirstName'] ?? null,
        'mother_middle_name' => $_POST['editMotherMiddleName'] ?? null,
        'mother_last_name' => $_POST['editMotherLastName'] ?? null,
        'mother_suffix' => $_POST['editMotherSuffix'] ?? null,
        'mother_birth_date' => $_POST['editMotherBirthDate'] ?? null,
        'mother_is_deceased' => $_POST['editMotherIsDeceased'] === 'true' ? 1 : 0,
        'mother_deceased_date' => $_POST['editMotherDeceasedDate'] ?? null,
        'mother_occupation' => $_POST['editMotherOccupation'] ?? null,
        'mother_educational_attainment' => $_POST['editMotherEducationalAttainment'] ?? null,
        'mother_contact_no' => $_POST['editMotherContactNo'] ?? null,
    ];

    $success = $residentModel->insertAddedInfo($resident_id, $data);
    
    if ($success) {
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?message=saved_successfully");
        exit();
    } else {
        echo "Failed to update resident info.";
    }
}