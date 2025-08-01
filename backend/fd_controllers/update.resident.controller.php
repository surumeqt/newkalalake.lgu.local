<?php
require_once __DIR__ . '/../models/resident.model.php';

$residentModel = new ResidentModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resident_id = $_POST['resident_id'] ?? null;

    if (!$resident_id) {
        die("Resident ID is required.");
    }

    $data = [
        // Resident's Personal Information
        'is_deceased' => $_POST['editIsDeceased'] === 'true' ? 1 : 0,
        'educational_attainment' => $_POST['editEducationalAttainment'] ?? null,
        'occupation' => $_POST['editOccupation'] ?? null,
        'job_title' => $_POST['editjobTitle'] ?? null,
        'monthly_income' => $_POST['editMonthlyIncome'] ?? null,

        // Emergency Contact Information
        'emergency_contact_name' => $_POST['editEmergencyContactName'] ?? null,
        'emergency_contact_relationship' => $_POST['editEmergencyContactRelationship'] ?? null,
        'emergency_contact_no' => $_POST['editEmergencyContactNo'] ?? null,

        // Business Information
        'have_a_business' => $_POST['haveABusiness'] ?? null,
        'business_name' => $_POST['editBusinessName'] ?? null,
        'business_address' => $_POST['editBusinessAddress'] ?? null,

        // Father's Profile
        'father_first_name' => $_POST['editFatherFirstName'] ?? null,
        'father_middle_name' => $_POST['editFatherMiddleName'] ?? null,
        'father_last_name' => $_POST['editFatherLastName'] ?? null,
        'father_suffix' => $_POST['editFatherSuffix'] ?? null,
        'father_birth_date' => $_POST['editFatherBirthDate'] ?? null,
        'father_age' => $_POST['editFatherAge'] ?? null,
        'father_is_deceased' => $_POST['editFatherIsDeceased'] === 'true' ? 1 : 0,
        // 'father_deceased_date' => $_POST['editFatherDeceasedDate'] ?? null, // This is not in the form
        'father_occupation' => $_POST['editFatherOccupation'] ?? null,
        'father_educational_attainment' => $_POST['editFatherEducationalAttainment'] ?? null,
        'father_contact_no' => $_POST['editFatherContactNo'] ?? null,

        // Mother's Profile
        'mother_first_name' => $_POST['editMotherFirstName'] ?? null,
        'mother_middle_name' => $_POST['editMotherMiddleName'] ?? null,
        'mother_last_name' => $_POST['editMotherLastName'] ?? null,
        'mother_suffix' => $_POST['editMotherSuffix'] ?? null,
        'mother_birth_date' => $_POST['editMotherBirthDate'] ?? null,
        'mother_age' => $_POST['editMotherAge'] ?? null,
        'mother_is_deceased' => $_POST['editMotherIsDeceased'] === 'true' ? 1 : 0,
        // 'mother_deceased_date' => $_POST['editMotherDeceasedDate'] ?? null, // This is not in the form
        'mother_occupation' => $_POST['editMotherOccupation'] ?? null,
        'mother_educational_attainment' => $_POST['editMotherEducationalAttainment'] ?? null,
        'mother_contact_no' => $_POST['editMotherContactNo'] ?? null,

        // Siblings Information
        'num_brothers' => $_POST['editBrothers'] ?? null,
        'num_sisters' => $_POST['editSisters'] ?? null,
        'order_of_birth' => $_POST['editOrderOfBirth'] ?? null,
    ];

    $recordExists = $residentModel->hasAddedInfo($resident_id);

    if ($recordExists) {
        $success = $residentModel->updateAddedInfo($resident_id, $data);
    } else {
        $success = $residentModel->insertAddedInfo($resident_id, $data);
    }

    if ($success) {
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?status=updated");
        exit();
    } else {
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?status=update_failed");
        exit();
    }
}