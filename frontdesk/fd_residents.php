<?php 
$userId = 202520310;
?>
<div class="residents-container">
    <h1>Resident Records</h1>

    <div class="flex-container">
        <input type="text" placeholder="Search residents..." id="search-input">
        <button id="add-resident-btn" class="open-resident-modal">Add a Resident</button>
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
                <tr>
                    <td><img src="https://www.kindpng.com/picc/m/722-7221920_placeholder-profile-image-placeholder-png-transparent-png.png" alt="placeholder"></td>
                    <td>John Kenneth Esmena</td>
                    <td>123 Norton Ave, New Kalalake, Olongapo City</td>
                    <td>Male</td>
                    <td>11-04-2002</td>
                    <td>22</td>
                    <td>07-24-2025</td>
                    <td class="action-buttons">
                        <button class="button edit-btn" onclick="editResident('<?php echo $userId; ?>')">Edit</button>
                        <button class="button delete-btn">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>