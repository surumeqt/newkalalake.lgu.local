<?php
require_once '../backend/models/get.records.model.php';
$recordModel = new GetRecordsModel();
$records = $recordModel->getCasesByHearingStatus('Rehearing');
?>
<div class="container-cases">
    <h2>Rehearing Case's PDF's</h2>
    <table>
        <thead>
            <tr>
                <th>Docket Case Number</th>
                <th>Hearing Type</th>
                <th>Print</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Docket_Case_Number']) ?></td>
                    <td><?= htmlspecialchars($row['Hearing_Type']) ?></td>
                    <td>
                        <a href="../backend/get.pdf.records.php?id=<?= $row['Document_ID'] ?>" target="_blank">View PDF</a>
                    </td>
                    <td><?= htmlspecialchars($row['Hearing_Status']) ?></td>
                    <td>
                        <button
                            class="open-summary-modal">
                            Report Summary
                        </button>
                        <button
                            class="open-lupon-modal"
                            data-docket="<?= htmlspecialchars($row['Docket_Case_Number']) ?>"
                            data-hearing="<?= htmlspecialchars($row['Hearing_Status']) ?>">
                            Change Status
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>