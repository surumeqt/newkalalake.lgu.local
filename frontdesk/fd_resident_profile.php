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

// Initialize photoSource with the dummy image path
$photoSource = 'images/residents/dummy_resident_.png';

// Check if an ID is passed in the URL and if it's a valid string (resident_id is VARCHAR)
if (isset($_GET['id']) && is_string($_GET['id']) && !empty($_GET['id'])) {
    $residentId = $_GET['id'];

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

        // --- CORRECTED POSITION FOR PHOTO SOURCE DETERMINATION ---
        // Now that $resident is populated, check for photo_path
        if (!empty($resident['photo_path'])) {
            $photoSource = htmlspecialchars($resident['photo_path']);
            $photoSource = str_replace('frontdesk/', '', $photoSource);
        }
        // --- END CORRECTED POSITION ---

    } else {
        // Resident not found in the database
        $residentName = "Resident Not Found";
        $residentDisplayId = "N/A";
        // Photo source remains the dummy image
    }
} else {
    // No ID passed or invalid ID
    $residentName = "No Resident Selected";
    $residentDisplayId = "N/A";
    // Photo source remains the dummy image
}
// --- End: Logic to load resident details ---

?>

<div class="page-content-header">
    <div class="back-con">
        <a class="back-btn" href="./fd_residents.php" data-load-content="true" data-url="fd_residents.php">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <h2>Resident Profile</h2>
</div>

<div class="resident-profile-container card">
    <div class="card-body">
        <div class="profile-header">

            <div class="profile-photo-area">
                <div class="profile-photo">
                    <img src="<?= $photoSource; ?>" alt="Resident Photo" class="profile-photo-lg">
                </div>
            </div>
            <div class="profile-details-summary">
                <h3><?= htmlspecialchars($residentName); ?></h3>
                <p><strong>ID:</strong> <?= htmlspecialchars($residentDisplayId); ?></p>
                <p>
                    <strong>Status:</strong>
                    <?php
                    $statusClass = 'status-active'; // Default to active
                    $statusText = 'Active';

                    if (isset($resident['is_banned']) && $resident['is_banned'] == 1) {
                        $statusClass = 'status-banned';
                        $statusText = 'Banned';
                    }
                    ?>
                    <span id="residentStatusBadge" class="status-badge <?= $statusClass; ?>"><?= $statusText; ?></span>
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
                <p><strong>Contact No.:</strong> <?= htmlspecialchars($resident['contact_number'] ?? 'N/A'); ?></p>
                <p><strong>Email:</strong><?= htmlspecialchars($resident['email'] ?? 'N/A'); ?></p>
            </div>
            <div class="profile-section address-info-section">
                <h4><i class="fas fa-map-marker-alt"></i> Address</h4>
                <p><strong>House No:</strong> <?= htmlspecialchars($resident['house_number'] ?? 'N/A'); ?></p>
                <p><strong>Street:</strong> <?= htmlspecialchars($resident['street'] ?? 'N/A'); ?></p>
                <p><strong>Purok/Zone:</strong> <?= htmlspecialchars($resident['purok'] ?? 'N/A'); ?></p>
                <p><strong>Barangay:</strong> <?= htmlspecialchars($resident['barangay'] ?? 'N/A'); ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($resident['city'] ?? 'N/A'); ?></p>

            </div>
            <div>
                <div class="profile-section admin-info-section">
                    <h4><i class="fas fa-tools"></i> Administration Info</h4>
                    <p><strong>Date Registered:</strong> <?= htmlspecialchars($resident['created_at'] ?? 'N/A'); ?></p>
                    <p><strong>Last Updated:</strong>
                        <?= htmlspecialchars($resident['updated_at'] ?? $resident['created_at'] ?? 'N/A'); ?></p>

                </div>
                <div class="profile-section profile-actions-bar">
                    <button id="OpenEditResidentModalBtn" class="btn btn-warning edit-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                    <?php if (isset($resident['is_banned']) && $resident['is_banned'] == 1): ?>
                    <button id="unbanResidentModalBtn" class="btn btn-good unban-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>">
                        <i class="fas fa-check-circle"></i> Unban Resident
                    </button>
                    <button id="banResidentModalBtn" class="btn btn-danger ban-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>" style="display: none;">
                        <i class="fas fa-ban"></i> Ban Resident
                    </button>
                    <?php else: ?>
                    <button id="banResidentModalBtn" class="btn btn-danger ban-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>">
                        <i class="fas fa-ban"></i> Ban Resident
                    </button>
                    <button id="unbanResidentModalBtn" class="btn btn-good unban-resident-btn"
                        data-resident-id="<?= htmlspecialchars($residentId); ?>" style="display: none;">
                        <i class="fas fa-check-circle"></i> Unban Resident
                    </button>
                    <?php endif; ?>
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
        <h3 style="margin-bottom:1rem; font-size: 1.5em; border-bottom: 1px solid #ccc; padding-bottom: 1rem;">Edit
            Resident Information</h3>
        <form id="editResidentForm" class="modal-form">
            <div class="form-divider">
                <div class="form-group">
                    <label for="edit_firstName">First Name:</label>
                    <input type="text" id="edit_firstName" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_middleName">Middle Name/Initial:</label>
                    <input type="text" id="edit_middleName" name="middle_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_lastName">Last Name:</label>
                    <input type="text" id="edit_lastName" name="last_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_suffix">Suffix:</label>
                    <input type="text" id="edit_suffix" name="suffix" class="form-control"
                        placeholder="e.g., Jr., Sr., III">
                </div>
            </div>
            <div class="form-divider">
                <div class="form-group">
                    <label for="edit_birthDate">Date of Birth:</label>
                    <input type="date" id="edit_birthDate" name="birthday" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_age">Age:</label>
                    <input type="number" id="edit_age" name="age" class="form-control" disabled required>
                </div>
                <div class="form-group">
                    <label for="edit_gender">Gender:</label>
                    <select id="edit_gender" name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_civilStatus">Civil Status:</label>
                    <select id="edit_civilStatus" name="civil_status" class="form-control" required>
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
                    <label for="edit_houseNumber">House No.:</label>
                    <input type="text" id="edit_houseNumber" name="houseNumber" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_street">Street:</label>
                    <input type="text" id="edit_street" name="street" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_purok">Purok/Zone:</label>
                    <input type="text" id="edit_purok" name="purok" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_barangay">Barangay:</label>
                    <input type="text" id="edit_barangay" name="barangay" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_city">City:</label>
                    <input type="text" id="edit_city" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_contact_number">Contact No.:</label>
                    <input type="text" id="edit_contact_number" name="contact_number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email Address:</label>
                    <input type="email" id="edit_email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem; border-top: 1px solid #ccc; padding-top: 1rem;">
                <label for="edit_photo">Resident Photo (Optional):</label>
                <input type="file" id="edit_photo" name="photo" accept="image/*" class="form-control-file">
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-good">Save</button>
                <button type="button" id="CloseEditResidentModalBtn" class="btn btn-cancel">Cancel</button>
            </div>
            <input type="hidden" id="edit_residentId" name="resident_id">
            <input type="hidden" name="action" value="update_resident">
        </form>
        </form>
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
        <input type="hidden" id="banResidentIdInput" value="">
        <div class="modal-actions">
            <button id="confirmBanResidentBtn" class="btn btn-confirm">Yes, Ban</button>
            <button id="br-closeModalBtn" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>
<div id="UnBanResidentModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Confirm UnBan</h3>
        <p>Are you sure you want to Unban this resident?</p>
        <input type="hidden" id="unbanResidentIdInput" value="">
        <div class="modal-actions">
            <button id="confirmUnBanResidentBtn" class="btn btn-confirm">Yes, Unban</button>
            <button id="ubr-closeModalBtn" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>

<script>
// Embed the PHP resident data into a JavaScript variable
// This variable will be accessible to the modal.logic.js after this script runs
const residentDataForEdit = <?php echo json_encode($resident); ?>;
console.log("Resident data embedded for edit:", residentDataForEdit); // For debugging
</script>