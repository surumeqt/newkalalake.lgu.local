<?php

require_once __DIR__ . '/../models/residents.model.php';
require_once __DIR__ . '/../helpers/formatters.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = formatAddress([
        'houseNumber' => $_POST['houseNumber'] ?? '',
        'street' => $_POST['street'] ?? '',
        'purok' => $_POST['purok'] ?? '',
        'barangay' => $_POST['barangay'] ?? '',
        'city' => $_POST['city'] ?? ''
    ]);
    $fd_Data = [
        'first_name'    => $_POST['first_name'] ?? '',
        'middle_name'   => $_POST['middle_name'] ?? '',
        'last_name'     => $_POST['last_name'] ?? '',
        'suffix'        => $_POST['suffix'] ?? '',
        'birthday'      => $_POST['birthday'] ?? '',
        'age'           => getAge() ?? '',
        'gender'        => $_POST['gender'] ?? '',
        'civil_status'  => $_POST['civil_status'] ?? '',
        'address'       => $address ?? '',
        'email'         => $_POST['email'] ?? '',
        'contact_number'=> $_POST['contact_number'] ?? '',
    ];

    $residentsModel = new Residents();
    $residentsModel->addResident($fd_Data);
    header('Location: ../../frontdesk/fd_app.php?success=Resident added successfully');
}