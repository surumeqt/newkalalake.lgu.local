<?php
require_once __DIR__ . '/../models/certificate.model.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'certificate_type' => $_POST['certificate_type'] ?? '',
        'resident_name' => $_POST['resident-name'] ?? '',
        'resident_age' => $_POST['resident-age'] ?? '',
        'resident_birthdate' => $_POST['resident-birthdate'] ?? '',
        'resident_address' => $_POST['resident-address'] ?? '',
        'resident_business_name' => $_POST['resident-business-name'] ?? '',
        'resident_business_address' => $_POST['resident-business-address'] ?? '',
        'purpose' => $_POST['purpose'] ?? '',
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