<?php
require_once './models/update.status.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $docket = $_POST['Docket_Case_Number'] ?? null;
    $newStatus = $_POST['Hearing_Status'] ?? null;
    $hearingDate = $_POST['Hearing_Date'] ?? null;
    $reportSummaryText = $_POST['report_summary_text'] ?? null;

    if ($docket && $newStatus && $reportSummaryText) {
        $model = new UpdateStatusModel();

        $summaryInserted = $model->saveSummaryDocument($docket, $reportSummaryText, $hearingDate);

        if ($summaryInserted) {
            $statusUpdated = $model->updateStatus($docket, $newStatus);
            $appealUpdated = $model->RehearingAppealType($docket, $hearingDate);

            header("Location: ../app/app.php?status=success");
            exit();
        }

        header("Location: ../app/app.php?status=failed");
        exit();
    } else {
        http_response_code(400);
        echo "Missing data for rehearing.";
    }
}
