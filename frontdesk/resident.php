<div class="resident-content">
    <h1>Resident Management</h1>

    <!-- Toolbar: Search Bar and Add Resident Button -->
    <section class="resident-toolbar">
        <div class="search-bar">
            <span class="search-icon">&#128269;</span> <!-- Magnifying Glass Icon -->
            <input type="text" id="residentSearchInput" placeholder="Search residents by name or address...">
        </div>
        <button type="button" class="btn btn-primary btn-add-resident" id="addResidentBtn">
            + Add New Resident
        </button>
    </section>

    <!-- Resident List Section -->
    <section class="resident-list-section">
        <h2>Resident List</h2>
        <div class="resident-table-container">
            <table class="resident-table" id="residentTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Date Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Static Data (will be replaced by dynamic data from JS/PHP) -->
                    <tr>
                        <td>Juan Dela Cruz</td>
                        <td>123 Main St, Brgy. New Kalalake</td>
                        <td>+639123456789</td>
                        <td>Single</td>
                        <td>2024-07-25</td>
                        <td>
                            <button class="action-btn btn-edit" data-id="1">Edit</button>
                            <button class="action-btn btn-delete" data-id="1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Maria Clara</td>
                        <td>456 Oak Ave, Brgy. New Kalalake</td>
                        <td>+639234567890</td>
                        <td>Married</td>
                        <td>2024-07-25</td>
                        <td>
                            <button class="action-btn btn-edit" data-id="2">Edit</button>
                            <button class="action-btn btn-delete" data-id="2">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Crisostomo Ibarra</td>
                        <td>789 Pine Ln, Brgy. New Kalalake</td>
                        <td>+639345678901</td>
                        <td>Single</td>
                        <td>2024-07-25</td>
                        <td>
                            <button class="action-btn btn-edit" data-id="3">Edit</button>
                            <button class="action-btn btn-delete" data-id="3">Delete</button>
                        </td>
                    </tr>
                    <!-- End Example Static Data -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Resident Form Modal -->
    <div id="residentFormModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Resident</h2>
                <span class="close-button">&times;</span>
            </div>
            <form id="residentForm">
                <input type="hidden" id="residentId" value=""> <!-- Hidden input for resident ID -->
                <div class="resident-form-grid">
                    <div class="form-group">
                        <label for="residentName">Full Name</label>
                        <input type="text" id="residentName" placeholder="e.g., Juan Dela Cruz" required>
                    </div>
                    <div class="form-group">
                        <label for="residentAddress">Address</label>
                        <input type="text" id="residentAddress" placeholder="e.g., 123 Main St, Brgy. New Kalalake" required>
                    </div>
                    <div class="form-group">
                        <label for="residentContact">Contact Number</label>
                        <input type="tel" id="residentContact" placeholder="e.g., +639123456789">
                    </div>
                    <div class="form-group">
                        <label for="residentEmail">Email (Optional)</label>
                        <input type="email" id="residentEmail" placeholder="e.g., juan@example.com">
                    </div>
                    <div class="form-group">
                        <label for="residentBirthdate">Birthdate</label>
                        <input type="text" id="residentBirthdate" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="residentStatus">Status</label>
                        <input type="text" id="residentStatus" placeholder="e.g., Single, Married">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelFormBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveResidentBtn">Save Resident</button>
                </div>
            </form>
        </div>
    </div>
</div>
