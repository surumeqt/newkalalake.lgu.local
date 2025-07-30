<?php
require_once '../backend/config/database.config.php';

$db = new Connection();
$conn = $db->connect();

$sql = "SELECT 
            c.id,
            c.certificate_type,
            c.fileBlob,
            r.first_name,
            r.middle_name,
            r.last_name,
            r.suffix
        FROM certificates c
        JOIN residents r ON c.resident_id = r.resident_id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="records-container">
    <h1>History Records</h1>
    <table>
        <thead>
            <tr>
                <th>Resident Name</th>
                <th>Certificate Type</th>
                <th>PDF File</th>
            </tr>
        </thead>
        <tbody id="records-table-body">
            <?php foreach ($certificates as $cert): ?>
            <tr>
                <td><?= htmlspecialchars($cert['first_name'] . (!empty($cert['middle_name']) ? ' ' . $cert['middle_name'] : '') . ' ' . $cert['last_name']) . (!empty($cert['suffix']) ? ' ' . $cert['suffix'] : '') ?></td>
                <td><?= htmlspecialchars($cert['certificate_type']) ?></td>
                <td>
                    <a href="../backend/fd_controllers/view.certificate.php?id=<?= $cert['id'] ?>" target="_blank">View PDF</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>