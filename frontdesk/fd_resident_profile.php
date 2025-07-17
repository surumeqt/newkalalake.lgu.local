<?php
// file: frontdesk/fd_resident_profile.php
include '../backend/config/database.config.php';
include '../backend/helpers/redirects.php';
require_once __DIR__ . '/../backend/models/residents.model.php'; // Include Residents model
require_once __DIR__ . '/../backend/helpers/formatters.php'; // Include formatters for getAge function
redirectIfNotLoggedIn();

// Get username from session for display (if used on this page)
$user_username = $_SESSION['username'] ?? 'Guest';

// --- Start: Logic to load resident details ---
$residentId = null;
$resident = null;
$residentName = "Loading Resident..."; // Default text while loading
$residentDisplayId = "Loading...";
$residentAge = "N/A"; // Initialize age

// Check if an ID is passed in the URL and if it's a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $residentId = (int)$_GET['id']; // Cast to integer for security and type consistency

    // Instantiate the Residents model
    $residentsModel = new Residents();

    // Fetch resident details using the new method in the model
    $resident = $residentsModel->getResidentById($residentId);

    if ($resident) {
        // Resident found, construct and display their name and ID
        $residentNameParts = [
            $resident['first_name'] ?? '',
            $resident['middle_name'] ?? '',
            $resident['last_name'] ?? '',
            $resident['suffix'] ?? ''
        ];
        // Filter out empty parts and join them to form the full name
        $residentName = implode(' ', array_filter($residentNameParts));
        $residentDisplayId = $resident['resident_id'] ?? 'N/A'; // Use the actual ID from the fetched data

        // Calculate age using the helper function
        if (isset($resident['birthday'])) {
            $calculatedAge = getAge($resident['birthday']);
            if ($calculatedAge !== null) {
                $residentAge = $calculatedAge;
            }
        }
    } else {
        // Resident not found in the database
        $residentName = "Resident Not Found";
        $residentDisplayId = "N/A";
    }
} else {
    // No ID passed or invalid ID
    $residentName = "No Resident Selected";
    $residentDisplayId = "N/A";
}
// --- End: Logic to load resident details ---

?>

<div class="page-content-header">
    <h2>Resident Profile</h2>
    <p class="current-page-title"><?= htmlspecialchars($residentName); ?></p>
</div>

<div class="resident-profile-container card">
    <div class="card-body">
        <div class="profile-header">
            <div class="profile-photo-area">
                <img src="../../assets/img/dummy_resident_<?= htmlspecialchars($resident['gender'] ?? 'male'); ?>.jpg"
                    alt="Resident Photo" class="profile-photo">
            </div>
            <div class="profile-details-summary">
                <h3><?= htmlspecialchars($residentName); ?></h3>
                <p><strong>ID:</strong> <?= htmlspecialchars($residentDisplayId); ?></p>
                <p>
                    <strong>Status:</strong>
                    <?php
                    $statusClass = 'status-inactive'; // Default to inactive
                    $statusText = 'Inactive';
                    if (isset($resident['status'])) {
                        if ($resident['status'] === 'Active') {
                            $statusClass = 'status-active';
                            $statusText = 'Active';
                        } else if ($resident['status'] === 'Banned') {
                            $statusClass = 'status-banned'; // Assuming you have this CSS class
                            $statusText = 'Banned';
                        } else {
                            // Default or other statuses
                            $statusClass = 'status-inactive';
                            $statusText = htmlspecialchars($resident['status']);
                        }
                    }
                    ?>
                    <span class="status-badge <?= $statusClass; ?>"><?= $statusText; ?></span>
                </p>
            </div>
        </div>

        <?php if ($resident): // Only display details if a resident was found 
        ?>
        <div class="profile-sections">
            <div class="profile-section basic-info-section">
                <h4><i class="fas fa-info-circle"></i> Basic Information</h4>
                <p><strong>Birth Date:</strong> <?= htmlspecialchars($resident['birthday'] ?? 'N/A'); ?></p>
                <p><strong>Age:</strong> <?= htmlspecialchars($residentAge); ?></p>
                <p><strong>Gender:</strong> <?= htmlspecialchars($resident['gender'] ?? 'N/A'); ?></p>
                <p><strong>Civil Status:</strong> <?= htmlspecialchars($resident['civil_status'] ?? 'N/A'); ?></p>
                <p><strong>Contact No.:</strong> <?= htmlspecialchars($resident['contact_no'] ?? 'N/A'); ?></p>
                <p><strong>Email:</strong><?= htmlspecialchars($resident['email'] ?? 'N/A'); ?></p>
                <h4><i class="fas fa-map-marker-alt"></i> Address</h4>
                <p><strong>Address:</strong> <?= htmlspecialchars($resident['address'] ?? 'N/A'); ?></p>
                <p><strong>Purok/Zone:</strong> <?= htmlspecialchars($resident['purok_zone'] ?? 'N/A'); ?></p>
            </div>
            <div>
                <div class="profile-section admin-info-section">
                    <h4><i class="fas fa-tools"></i> Administration Info</h4>
                    <p><strong>Date Registered:</strong> <?= htmlspecialchars($resident['created_at'] ?? 'N/A'); ?></p>
                    <p><strong>Last Updated:</strong>
                        <?= htmlspecialchars($resident['updated_at'] ?? $resident['created_at'] ?? 'N/A'); ?></p>

                </div>
                <div class="profile-section profile-actions-bar" style="height: 100%;">
                    <button id="OpenEditResidentModalBtn" class="btn btn-warning edit-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                    <button id="banResidentModalBtn" class="btn btn-danger ban-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>">
                        <i class="fas fa-ban"></i> Ban Resident
                    </button>
                    <button id="deleteResidentModalBtn" class="btn btn-secondary delete-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>">
                        <i class="fas fa-trash-alt"></i> Delete Resident
                    </button>
                </div>
            </div>


        </div>


        <?php else: ?>
        <p class="text-center text-danger">No resident data available.</p>
        <?php endif; ?>

        <div class="profile-section issued-certificates-section">
            <h4><i class="fas fa-certificate"></i> Issued Certificates History</h4>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Certificate Type</th>
                            <th>Purpose</th>
                            <th>Date Issued</th>
                            <th>Issued By</th>
                            <th>Document</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" style="text-align: center;">No certificate history available.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="EditResidentModal" class="modal-overlay">
    <div class="edit-resident-modal-content">
        <h3>Edit Resident Information</h3>
        <form id="editResidentForm" class="modal-form">
            <div class="form-divider">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="middleName">Middle Name/Initial:</label>
                    <input type="text" id="middleName" name="middle_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="last_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="suffix">Suffix:</label>
                    <input type="text" id="suffix" name="suffix" class="form-control" placeholder="e.g., Jr., Sr., III">
                </div>
            </div>
            <div class="form-divider">
                <div class="form-group">
                    <label for="birthDate">Date of Birth:</label>
                    <input type="date" id="birthDate" name="birthday" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" class="form-control" disabled required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <!-- <option value="Other">Other</option> -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="civilStatus">Civil Status:</label>
                    <select id="civilStatus" name="civil_status" class="form-control" required>
                        <option value="">Select Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                        <option value="Annulled">Annulled</option>
                        <option value="Divorced">Divorced</option>
                    </select>
                </div>
            </div>
            <div class="form-divider">
                <div class="form-group">
                    <label for="houseNumber">House No.:</label>
                    <input type="text" id="houseNumber" name="houseNumber" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="purok">Purok/Zone:</label>
                    <input type="text" id="purok" name="purok" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay:</label>
                    <input type="text" id="barangay" name="barangay" class="form-control" value="New Kalalake" readonly
                        required>
                </div>
                <!-- <div class="form-group">
                    <label for="contactNumber">Number (Optional):</label>
                    <input type="tel" id="contactNumber" name="contact_number" class="form-control" pattern="[0-9]{11}"
                        placeholder="e.g., 09123456789">
                </div> -->
            </div>

            <div class="form-group">
                <label for="photo">Resident Photo (Optional):</label>
                <input type="file" id="photo" name="photo" accept="image/*" class="form-control-file">
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-good">Save</button>
                <button type="button" id="CloseEditResidentModalBtn" class="btn btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="SelectCertificateTypeModal2" class="modal-overlay">
    <div class="select-certificate-modal-content2">
        <h3>Select Certificate Type</h3>
        <input type="hidden" id="selectCertResidentId" name="resident_id">
        <div class="certificateTypeBtn">
            <button type="button" class="btn btn-select" data-certificate-type="Indigency Certificate">
                Certificate of Indigency
            </button>
            <button type="button" class="btn btn-select" data-certificate-type="Residency Certificate">
                Barangay Residency
            </button>
            <button type="button" class="btn btn-select" data-certificate-type="Non-Residency Certificate">
                Certificate of Non-Residency
            </button>
            <button type="button" class="btn btn-select" data-certificate-type="Barangay Permit">
                Barangay Permit
            </button>
            <button type="button" class="btn btn-select" data-certificate-type="Barangay Endorsement">
                Barangay Endorsement
            </button>
            <button type="button" class="btn btn-select" data-certificate-type="Vehicle Clearance">
                Vehicle Clearance
            </button>
        </div>
        <div class="modal-actions">
            <button id="sc-closeModalBtn" type="button"
                class="btn btn-cancel-2 close-select-cert-modal-btn">Cancel</button>
        </div>
    </div>
</div>

<div id="DeleteResidentModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this resident?</p>
        <div class="modal-actions">
            <button id="confirmLogout" class="btn btn-confirm">Yes, Delete</button>
            <button id="dr-closeModalBtn" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>
<div id="BanResidentModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Confirm Ban</h3>
        <p>Are you sure you want to ban this resident?</p>
        <div class="modal-actions">
            <button id="confirmLogout" class="btn btn-confirm">Yes, Ban</button>
            <button id="br-closeModalBtn" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>