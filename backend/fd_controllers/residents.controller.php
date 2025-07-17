<?php

require_once __DIR__ . '/../models/residents.model.php';
require_once __DIR__ . '/../helpers/formatters.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchInput = $_POST['residentSearchInput'] ?? '';
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

    $records = $residentsModel->getResidentsByName($searchInput);

    foreach ($records as $row) {
        echo "
        <tr>
            <td>
                <div class='table-thumbnail'>
                    <i class='fas fa-user-circle default-thumbnail'></i>
                </div>
            </td>
            <td>".htmlspecialchars($rows['first_name'].' '.$rows['middle_name'].' '.$rows['last_name'].' '.$rows['suffix'] ?? '')."</td>
            <td>".htmlspecialchars($rows['address'])."</td>
            <td>".htmlspecialchars($rows['gender']) ."</td>
            <td>".htmlspecialchars($rows['birthday'])."</td>
            <td>Barangay Residency</td>
            <td>".htmlspecialchars($rows['created_at'])."</td>

            <td>
                <button id='OpenNewCertificateRequestModalBtn'
                    class='btn btn-sm btn-primary issue-certificate-btn'>
                    <i class='fas fa-file-alt'></i> Issue
                </button>
                <button class='btn btn-sm btn-info view-resident-btn' data-url='./fd_resident_profile.php'
                    data-load-content='true'><i class='fas fa-eye'></i> View
                </button>
            </td>
        </tr>";
    }
}