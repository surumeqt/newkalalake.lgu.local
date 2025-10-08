<?php
require_once __DIR__ . '/../models/resident.model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentModel = new ResidentModel();
    $resident_id = $_POST['resident_id'] ?? null;

    if (!$resident_id) {
        die("Resident ID is required.");
    }

    $encodedBlob = null;
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'][0] === UPLOAD_ERR_OK) {
        $fileBlobs = [];
        foreach ($_FILES['file_upload']['tmp_name'] as $index => $tmpName) {
            $filedata = file_get_contents($tmpName);
            // It's better to store the raw binary data directly, not Base64 encoded in the database.
            // Let's pass the raw data to the model.
            $fileBlobs[] = $filedata;
        }
        if (!empty($fileBlobs)) {
            // Pass the raw data directly to the model.
            $encodedBlob = $fileBlobs[0];
        }
    } else {
        error_log("No photo uploaded or upload error: " . $_FILES['file_upload']['error'][0]);
    }

    // Add the file blob to the data array only if it exists.
    $data = [
        // Resident's Personal Information in table residents
        'editFirstName' => $_POST['editFirstName'] ?? null,
        'editMiddleName' => $_POST['editMiddleName'] ?? null,
        'editLastName' => $_POST['editLastName'] ?? null,
        'editSuffix' => $_POST['editSuffix'] ?? null,
        'editBirthDate' => $_POST['editBirthDate'] ?? null,
        'editAge' => $_POST['editAge'] ?? null,
        'editGender' => $_POST['editGender'] ?? null,
        'editCivilStatus' => $_POST['editCivilStatus'] ?? null,
        'editAddress' => $_POST['editAddress'] ?? null,
        'editContactNo' => $_POST['editContactNo'] ?? null,
        'editEmail' => $_POST['editEmail'] ?? null,
        'fileBlob' => $encodedBlob, // Pass raw blob data

        // the rest of the data are from table residents_added_info
        // Resident's additional Personal Information
        'is_deceased' => $_POST['editIsDeceased'] === 'true' ? 1 : 0,
        'deceased_date' => $_POST['editDeceasedDate'] ?? null,
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

    // Wrap the updates in a transaction for atomicity
    try {
        $residentModel->startTransaction();

        // 1. Update the main residents table
        $success1 = $residentModel->updateResident($resident_id, $data);

        // 2. Update or insert into the residents_added_info table
        $recordExists = $residentModel->hasAddedInfo($resident_id);

        if ($recordExists) {
            $success2 = $residentModel->updateAddedInfo($resident_id, $data);
        } else {
            $success2 = $residentModel->insertAddedInfo($resident_id, $data);
        }

        if ($success1 && $success2) {
            $residentModel->commitTransaction();
            header("Location: /frontdesk/fd_app.php?status=updated");
            exit();
        } else {
            $residentModel->rollBackTransaction();
            header("Location: /frontdesk/fd_app.php?status=update_failed");
            exit();
        }
    } catch (Exception $e) {
        $residentModel->rollBackTransaction();
        // Log the error for debugging
        error_log("Transaction failed: " . $e->getMessage());
        header("Location: /frontdesk/fd_app.php?status=update_failed");
        exit();
    }
}
