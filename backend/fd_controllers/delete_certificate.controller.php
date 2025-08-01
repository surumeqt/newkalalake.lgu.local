<?php
require_once __DIR__ . '/../models/certificate.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_certificate'])) {
    $certificate_id = $_POST['certificate_id'];

    $model = new CertificateModel();
    $deleted = $model->deleteCertificate($certificate_id);

    if ($deleted) {
        header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?status=cert_deleted");
        exit();
    } else {
        echo "Failed to delete certificate.";
    }
}