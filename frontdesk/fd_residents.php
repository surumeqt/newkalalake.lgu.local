<?php 
require_once __DIR__ . '/../backend/models/resident.model.php';

$model = new ResidentModel();
$records = $model->getResidents();
?>
<div class="residents-container">
    <h1>Resident Records</h1>

    <div class="flex-container">
        <input type="text" placeholder="Search residents..." id="search-input" onkeyup="liveSearch()">
        <button id="add-resident-btn" class="open-resident-modal" onclick="addResident()">Add a Resident</button>
    </div>

    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th>Age</th>
                    <th>Date Encoded</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="residents-table-body">
                <?php if (empty($records)): ?>
                    <tr><td colspan="9" style="text-align: center;">No records found.</td></tr>
                <?php else: ?>
                    <?php foreach (array_slice($records, 0, 10) as $rows): ?>
                        <tr>
                            <td>
                                <img src="https://www.kindpng.com/picc/m/722-7221920_placeholder-profile-image-placeholder-png-transparent-png.png" alt="placeholder">
                            </td>
                            <td><?= htmlspecialchars($rows['first_name'].' '.$rows['middle_name'].' '.$rows['last_name']) ?></td>
                            <td><?= htmlspecialchars($rows['address']) ?></td>
                            <td><?= htmlspecialchars($rows['gender']) ?></td>
                            <td><?= htmlspecialchars($rows['birthday']) ?></td>
                            <td><?= htmlspecialchars($rows['age']) ?></td>
                            <td><?= htmlspecialchars($rows['created_at']) ?></td>
                            <td class="action-buttons">
                                <button class="button edit-btn" onclick="editResident('<?php echo $rows['resident_id']; ?>')">Edit</button>
                                <button class="button delete-btn" onclick="deleteResident('<?php echo $rows['resident_id']; ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>