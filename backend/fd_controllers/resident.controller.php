<?php
require_once __DIR__ . '/../models/resident.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residentModel = new ResidentModel();

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
    ];
    
    $residentModel->createResident($data);
    header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php");
}
