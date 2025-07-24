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
                    <th>Last Certificate Issued</th>
                    <th>Date Issued</th>
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
                    <td>Barangay Residency Certificate</td>
                    <td>11-04-2023</td>
                    <td class="action-buttons">
                        <button class="button edit-btn">Edit</button>
                        <button class="button delete-btn">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>