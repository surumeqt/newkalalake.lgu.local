<?php
require_once __DIR__ . '/../models/resident.model.php';

$searchInput = $_POST['SearchByName'];

$model = new ResidentModel();
$records = $model->searchByLnameOrFname($searchInput);

if (empty($records)) {
    echo '<tr><td colspan="9" style="text-align:center;">No records found.</td></tr>';
} else {
    foreach (array_slice($records, 0, 10) as $rows) {

        $photoData = json_decode($rows['photo'], true);
        $photoSrc = (!empty($photoData) && isset($photoData[0]))
            ? 'data:image/jpeg;base64,' . $photoData[0]
            : 'https://www.kindpng.com/picc/m/722-7221920_placeholder-profile-image-placeholder-png-transparent-png.png';

        echo "
            <tr>
                <td>
                    <img src=\"$photoSrc\" alt=\"Resident Photo\">
                </td>
                <td>" . htmlspecialchars($rows['first_name'] . ' ' . $rows['middle_name'] . ' ' . $rows['last_name']) . "</td>
                <td>" . htmlspecialchars($rows['address']) . "</td>
                <td>" . htmlspecialchars($rows['gender']) . "</td>
                <td>" . htmlspecialchars($rows['birthday']) . "</td>
                <td>" . htmlspecialchars($rows['age']) . "</td>
                <td>" . htmlspecialchars($rows['created_at']) . "</td>
                <td class='action-buttons'>
                    <button class=\"button edit-btn\" onclick=\"openEditModal('{$rows['resident_id']}')\">Edit</button>
                    <button class=\"button delete-btn\" onclick=\"deleteResident('{$rows['resident_id']}')\">Delete</button>
                </td>
            </tr>
        ";
    }
}