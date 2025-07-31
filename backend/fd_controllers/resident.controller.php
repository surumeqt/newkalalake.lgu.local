<?php
require_once __DIR__ . '/../models/resident.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residentModel = new ResidentModel();
    $fileBlobs = [];
    foreach ($_FILES['file_upload']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['file_upload']['error'][$index] === UPLOAD_ERR_OK) {
            $filedata = file_get_contents($tmpName);
            $fileBlobs[] = base64_encode($filedata);
        }
    }
    if (!empty($fileBlobs)) {
        $encodedBlob = json_encode($fileBlobs);
    }
    $data = [
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'suffix' => $_POST['suffix'],
        'birthday' => $_POST['birthday'],
        'age' => $_POST['age'],
        'gender' => $_POST['gender'],
        'civil_status' => $_POST['civil_status'],
        'houseNumber' => $_POST['houseNumber'],
        'street' => $_POST['street'],
        'purok' => $_POST['purok'],
        'barangay' => $_POST['barangay'],
        'city' => $_POST['city'],
        'contact' => $_POST['contact'],
        'email' => $_POST['email'],
        'fileBlob' => $encodedBlob
    ];
    try {
        $residentModel->createResident($data);
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?status=success");
        exit();
    } catch (PDOException $e) {
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?status=error");
        exit();
    }
}