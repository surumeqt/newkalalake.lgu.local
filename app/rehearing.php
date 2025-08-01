<?php
require_once '../backend/models/get.records.model.php';
$recordModel = new GetRecordsModel();
$records = $recordModel->getCasesByHearingStatus('Rehearing');
?>
<div class="container-cases">
    <h2>Rehearing Cases</h2>
    <?php if (empty($records)): ?>
        <p class="no-records-message">No Rehearing Cases.</p>
    <?php else: ?>
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
                            <a href="../backend/get.pdf.records.php?id=<?= $row['ID'] ?>" target="_blank" class="view-pdf-link">View PDF</a>
                        </td>
                        <td><?= htmlspecialchars($row['Hearing_Status']) ?></td>
                        <td>
                            <button
                                class="open-combined-action-modal action-button"
                                data-docket="<?= htmlspecialchars($row['Docket_Case_Number']) ?>"
                                data-hearing="<?= htmlspecialchars($row['Hearing_Status']) ?>">
                                Report Summary / Change Status
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
