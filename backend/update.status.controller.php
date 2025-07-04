<?php
require_once './models/update.status.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $docket = $_POST['Docket_Case_Number'] ?? null;
    $newStatus = $_POST['Hearing_Status'] ?? null;

    if ($docket && $newStatus) {
        $model = new UpdateStatusModel();
        $success = $model->updateStatus($docket, $newStatus);

        if ($success) {
            header("Location: ../app/app.php?status=success");
            exit();
        } else {
            header("Location: ../app/app.php?status=failed");
            exit();
        }
    } else {
        http_response_code(400);
        echo "Missing data. Docket: " . ($docket ?? 'N/A') . ", New Status: " . ($newStatus ?? 'N/A');
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
