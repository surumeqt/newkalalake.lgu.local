<?php
require_once __DIR__ . '/../models/certificate.model.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'certificate_type' => $_POST['certificate_type'] ?? '',
        'resident_name' => $_POST['resident-name'] ?? '',
        'resident_age' => $_POST['resident-age'] ?? '',
        'resident_birthdate' => $_POST['resident-birthdate'] ?? '',
        'resident_address' => $_POST['resident-address'] ?? '',
        'resident_monthly_salary' => $_POST['resident-monthly-salary'] ?? '',
        'resident_occupation' => $_POST['resident-occupation'] ?? '',
        'resident_business_name' => $_POST['resident-business-name'] ?? '',
        'resident_business_address' => $_POST['resident-business-address'] ?? '',
        'purpose' => $_POST['purpose'] ?? '',
        'vehicle_type' => $_POST['vehicle-type'],
        'vehicle_make' => $_POST['vehicle-make'],
        'vehicle_color' => $_POST['vehicle-color'],
        'vehicle_year_model' => $_POST['vehicle-model'],
        'vehicle_plate_number' => $_POST['vehicle-plate'],
        'vehicle_body_number' => $_POST['vehicle-body-number'],
        'vehicle_cr_number' => $_POST['vehicle-cr-number'],
        'vehicle_motor_number' => $_POST['vehicle-motor-number'],
        'vehicle_chasis_number' => $_POST['vehicle-chasis-number'],
        'issued_by' => $_SESSION['username'] ?? ''
    ];
    try {
        $model = new CertificateModel();
        $model->createCertificate($data);
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php");
        exit();
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}