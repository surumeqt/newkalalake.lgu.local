<?php
require_once './models/case.model.php';
header('Content-Type: application/json');

if (!isset($_GET['docket'])) {
    echo json_encode([]);
    exit;
}

$docket = $_GET['docket'];
$model = new CaseEntry();
$imagesJson = $model->getCaseFiles($docket);

if ($imagesJson) {
    $decodedImages = json_decode($imagesJson, true);

    if (json_last_error() === JSON_ERROR_NONE && is_array($decodedImages)) {
        echo $imagesJson;
    } else {
        error_log("Non-JSON or invalid array data retrieved for docket {$docket}: " . $imagesJson);
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
exit;