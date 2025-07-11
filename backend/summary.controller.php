<?php
require_once './models/update.status.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $docket = $_POST['Docket_Case_Number'] ?? null;
    $newStatus = $_POST['Hearing_Status'] ?? null;
    $reportSummaryText = $_POST['report_summary_text'] ?? null;

    if ($docket && $newStatus && $reportSummaryText) {
        $model = new UpdateStatusModel();

        $summaryInserted = $model->saveSummaryDocument($docket, $reportSummaryText, $hearingDate = null);

        if ($summaryInserted) {
            $newhearingDate = $_POST['Hearing_Date'];
            $statusUpdated = $model->updateStatus($docket, $newStatus);
            $appealUpdated = $model->RehearingAppealType($docket, $newhearingDate);

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
