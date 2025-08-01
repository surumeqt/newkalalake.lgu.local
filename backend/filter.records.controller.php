<?php
require_once './models/get.records.model.php';

$model = new GetRecordsModel();

$docket = $_POST['SearchByDcn'] ?? '';
$status = $_POST['Hearing_status'] ?? 'All_Status';
$limit = 10;

$records = [];

if (!empty($docket)) {
    $records = $model->filterSummaryByDocketNumber($docket);
} elseif ($status !== 'All_Status') {
    $records = $model->filterSummaryByStatus($status);
} else {
    $records = array_slice($model->getSummaryHistory(), 0, $limit);
}

if (empty($records)) {
    echo '<tr><td colspan="9" style="text-align:center;">No records found.</td></tr>';
    return;
}

foreach ($records as $row) {
    echo "
    <tr>
        <td>" . htmlspecialchars($row['Docket_Case_Number']) . "</td>
        <td>" . htmlspecialchars($row['Case_Title']) . "</td>
        <td>" . htmlspecialchars($row['Complainant_Name']) . "</td>
        <td>" . htmlspecialchars($row['Respondent_Name']) . "</td>
        <td>" . htmlspecialchars($row['Hearing_Type']) . "</td>
        <td><a href='../backend/get.summary.record.php?id=" . $row['ID'] . "' target='_blank'>View Summary</a></td>
        <td class='status-" . strtolower(str_replace(' ', '-', $row['Hearing_Status'])) . "'>" . htmlspecialchars($row['Hearing_Status']) . "</td>
        <td>" . htmlspecialchars(date('Y-m-d', strtotime($row['Created_At']))) . "</td>
        <td>
            <button 
                class='table-action-btn view-btn'
                data-docket=". htmlspecialchars($row['Docket_Case_Number']) . "
                >View
            </button>
        </td>
    </tr>";
}
