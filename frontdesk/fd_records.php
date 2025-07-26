<?php
require_once '../backend/config/database.config.php';

$db = new Connection();
$conn = $db->connect();

$sql = "SELECT * FROM certificates";

$stmt = $conn->prepare($sql);
$stmt->execute();
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="records-container">
    <h1>History Records</h1>
    <table>
        <thead>
            <tr>
                <th>Resident ID</th>
                <th>Certificate Type</th>
                <th>PDF File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certificates as $cert): ?>
            <tr>
                <td><?= htmlspecialchars($cert['resident_id']) ?></td>
                <td><?= htmlspecialchars($cert['certificate_type']) ?></td>
                <td>
                    <a href="../backend/fd_controllers/view.certificate.php?id=<?= $cert['id'] ?>" target="_blank">View PDF</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>