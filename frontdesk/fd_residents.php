<?php
// file: frontdesk/fd_residents.php
include '../backend/helpers/redirects.php';
require_once __DIR__ . '/../backend/models/residents.model.php';
redirectIfNotLoggedIn();

// Check for and display messages
if (isset($_SESSION['message'])) {
    $message_type = $_SESSION['message_type'] ?? 'info'; // 'success', 'error', 'info', 'warning'
    $message = $_SESSION['message'];

    // Clear the session messages so they don't reappear on refresh
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
?>
<div class="alert alert-<?= $message_type; ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($message); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
}
$user_username = $_SESSION['username'] ?? 'Guest';
$residentsModel = new Residents();

// --- Pagination Logic ---
$itemsPerPage = 10; // Number of residents to display per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// IMPORTANT: These methods (getTotalResidentsCount, getResidentsPaginated)
// need to be added to your Residents model (backend/models/residents.model.php).
// See the conceptual code for the Residents model below.

// Get total count of residents for pagination calculation (can be filtered by search later)
$totalResidents = $residentsModel->getTotalResidentsCount();
$totalPages = ceil($totalResidents / $itemsPerPage);

// Get residents for the current page
$records = $residentsModel->getResidentsPaginated($itemsPerPage, $offset);

// If no records found, ensure $records is an empty array to avoid foreach error
if (!$records) {
    $records = [];
}
?>

<div class="page-content-header">
    <h2>Resident Management</h2>
    <div class="header-actions">
        <div class="search-bar">
            <input type="text" id="residentSearchInput" class="form-control" name="search"
                placeholder="Search residents Name, Address, etc." onkeyup="liveSearch()">
        </div>
        <button class="btn btn-success add-resident-btn" id="openModalBtn">
            <span class="btn-img-con-1">
                <img class="btn-img" src="images/icons/add-user.png" alt="add-user">
            </span>
            Register New Resident
        </button>
    </div>
</div>
<div class="residents-list-section card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
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
                <tbody id="residents-body">
                    <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">No residents found.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($records as $row): ?>
                    <tr>
                        <td>
                            <div class="table-thumbnail">
                                <?php
                                        // Determine the photo source for each resident
                                        $residentPhotoSource = 'images/residents/dummy_resident_.png'; // Default dummy image
                                        if (!empty($row['photo_path'])) {
                                            $cleanPath = str_replace('frontdesk/', '', $row['photo_path']);
                                            $residentPhotoSource = htmlspecialchars($cleanPath);
                                        }
                                        ?>
                                <img src="<?= $residentPhotoSource; ?>" alt="Resident Photo"
                                    class="resident-photo-thumb">
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix'] ?? ''); ?>
                        </td>
                        <td>
                            <?php
                                    // Construct the full address for display from new columns
                                    $displayAddress = [];
                                    if (!empty($row['house_number'])) $displayAddress[] = htmlspecialchars($row['house_number']);
                                    if (!empty($row['street'])) $displayAddress[] = htmlspecialchars($row['street']);
                                    if (!empty($row['purok'])) $displayAddress[] = htmlspecialchars($row['purok']);
                                    if (!empty($row['barangay'])) $displayAddress[] = htmlspecialchars($row['barangay']);
                                    if (!empty($row['city'])) $displayAddress[] = htmlspecialchars($row['city']);
                                    echo implode(' ', array_filter($displayAddress)); // Use array_filter for clean output
                                    ?>
                        </td>
                        <td><?= htmlspecialchars($row['gender']); ?></td>
                        <td><?= htmlspecialchars($row['birthday']); ?></td>
                        <td>Barangay Residency</td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary issue-certificate-btn open-new-certificate-modal-btn"
                                data-resident-id="<?= htmlspecialchars($row['resident_id']); ?>"
                                data-resident-name="<?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix'] ?? ''); ?>">
                                Issue
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/document.png" alt="issue certificate">
                                </span>
                            </button>
                            <button class="btn btn-sm btn-info view-resident-btn" data-url="./fd_resident_profile.php"
                                data-load-content="true"
                                data-resident-id="<?= htmlspecialchars($row['resident_id']); ?>">
                                View
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/view.png" alt="view resident">
                                </span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="table-pagination">
            <?php if ($totalPages > 1): ?>
            <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" class="page-link" data-page="<?= $currentPage - 1 ?>">&laquo;
                Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="page-link <?= ($i == $currentPage) ? 'active' : '' ?>"
                data-page="<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" class="page-link" data-page="<?= $currentPage + 1 ?>">Next
                &raquo;</a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="AddresidentModal" class="modal-overlay">
    <div class="add-resident-modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h2 class="modal-title">Register New Resident</h2>
        </div>
        <form id="addResidentForm" class="modal-form" action="../backend/fd_controllers/residents.controller.php"
            method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-divider">
                    <h3 class="section-title">Personal Information</h3>
                    <!-- Name Fields Row -->
                    <div class="grid-4">
                        <div class="form-group">
                            <label for="firstName" class="field-label">First Name <span
                                    class="required">*</span></label>
                            <input type="text" id="firstName" name="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="middleName" class="field-label">Middle Name/Initial </label>
                            <input type="text" id="middleName" name="middle_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="field-label">Last Name <span class="required">*</span></label>
                            <input type="text" id="lastName" name="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="suffix">Suffix</label>
                            <input type="text" id="suffix" name="suffix" class="form-control"
                                placeholder="Jr., Sr., III">
                        </div>
                    </div>
                    <!-- Birth & Demographics Row -->
                    <div class="grid-4">
                        <div class="form-group">
                            <label for="birthDate" class="field-label">Date of Birth <span
                                    class="required">*</span></label>
                            <input type="date" id="birthDate" name="birthday" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="age" class="field-label">Age:</label>
                            <input type="number" id="age" name="age" class="form-control readonly"
                                placeholder="Auto Generated" required>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="field-label">Gender <span class="required">*</span></label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="civilStatus" class="field-label">Civil Status <span
                                    class="required">*</span></label>
                            <select id="civilStatus" name="civil_status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                                <option value="Annulled">Annulled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Address Information Section -->
                <div class="form-divider">
                    <h3 class="section-title">Address Information</h3>
                    <!-- Address Row 1 -->
                    <div class="grid-3">
                        <div class="form-group">
                            <label for="houseNumber" class="field-label">House No. <span class="required">*</span>
                            </label>
                            <input type="text" id="houseNumber" name="houseNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="street" class="field-label">Street <span class="required">*</span></label>
                            <input type="text" id="street" name="street" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="purok" class="field-label">Purok / Zone</label>
                            <input type="text" id="purok" name="purok" class="form-control">
                        </div>

                    </div>
                    <!-- Address Row 2 -->
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="barangay" class="field-label">Barangay <span class="required">*</span></label>
                            <input type="text" id="barangay" name="barangay" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="city" class="field-label">City <span class="required">*</span></label>
                            <input type="text" id="city" name="city" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-divider">
                    <h3 class="section-title">Contact Information</h3>
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="contact_number" class="field-label">
                                Contact No.
                                <span class="optional">(Optional)</span>
                            </label>
                            <input type="tel" id="contact_number" name="contact_number" class="form-control"
                                placeholder="+63 XXX XXX XXXX">
                        </div>
                        <div class="form-group">
                            <label for="email" class="field-label">Email Address <span
                                    class="optional">(Optional)</span></label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="example@email.com">
                        </div>
                    </div>
                </div>
                <!-- Photo Upload Section -->
                <div class="form-divider">
                    <h3 class="section-title">Resident Photo Upload</h3>

                    <div class="photo-upload-container">
                        <div class="photo-upload-area">
                            <div class="form-group">
                                <label class="field-label" for="photo">Upload Photo (Optional)</label>
                                <div class="upload-button-container">
                                    <input type="file" id="photo" name="photo" accept="image/*"
                                        class="form-control-file" style="display: none;">
                                    <button type="button" class="upload-button">
                                        <span>
                                            <img src="images/icons/upload-icon.png" alt="upload-icon">
                                        </span>
                                        Choose Image File
                                    </button>
                                    <span class="file-name" style="display: none"></span>
                                </div>
                            </div>
                        </div>
                        <div class="photo-preview" style="display: none">
                            <img class="preview-image" alt="Photo preview" />
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" value="add_resident">
            </div>
            <div class="modal-actions">
                <button type="button" id="closeModalBtn" class="btn btn-cancel">Cancel</button>
                <button type="submit" class="btn btn-good">Register Resident</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Overlay -->
<div id="NewCertificateRequestModal" class="modal-overlay">
    <!-- Modal Content -->
    <div class="new-certificate-request-modal-content">
        <h3 style="text-align: center;">Request New Certificate</h3>

        <form id="newCertificateRequestForm" class="modal-form">
            <div class="form-group-2">
                <label for="residentSearchInput">Selected Resident:</label>
                <input type="text" id="residentSearchInput" class="form-control-2" placeholder="Selected Resident"
                    disabled style="text-transform: capitalize;">
                <div id="residentSearchResults" class="search-results-dropdown">
                </div>
                <input type="hidden" id="selectedResidentId" name="resident_id">
            </div>

            <div id="selectedResidentInfo" class="selected-resident-info">
                <p>
                    <strong>Selected Resident Status:</strong>
                    <span id="residentStatusDisplay" style="font-weight: bold;">N/A</span>
                </p>
                <div id="residentBanWarning" class="alert alert-danger" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i> This resident is currently
                    <strong class="text-danger">BANNED</strong>
                    from receiving certificates. Reason:
                    <span id="banReasonDisplay"> Lupon Case or Pending Due</span>
                </div>
            </div>

            <div class="form-group-2">
                <label for="selectCertificateType">Certificate Type:</label>
                <select id="selectCertificateType" name="certificate_type_name" class="form-control-2" required>
                    <option value="">-- Select Certificate Type --</option>
                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                    <option value="Barangay Residency">Barangay Residency</option>
                    <option value="Certificate of Non-Residency">Certificate of Non-Residency</option>
                    <option value="Barangay Permit">Barangay Permit</option>
                    <option value="Barangay Endorsement">Barangay Endorsement</option>
                    <option value="Vehicle Clearance">Vehicle Clearance</option>
                </select>
            </div>

            <div class="form-group-2" id="photoUploadGroup" style="display: none;">
                <label for="certificatePhoto">Resident Photo (Optional for some certificates):</label>
                <input type="file" id="certificatePhoto" name="certificate_photo" accept="image/*"
                    class="form-control-2">
                <p class="form-text text-muted">A photo may be required for certain certificate types.</p>
            </div>


            <div class="form-certificate-specific-fields" data-certificate-type="default_purpose"
                style="display: none;">
                <div class="form-group-2">
                    <label for="defaultPurpose">Purpose:</label>
                    <textarea id="defaultPurpose" name="purpose" class="form-control-2" rows="3"
                        placeholder="e.g., For school enrollment, For job application, For business registration"></textarea>
                </div>
                <div class="form-group-2"></div>
            </div>

            <div class="form-certificate-specific-fields" data-certificate-type="Barangay Endorsement"
                style="display: none;">
                <div class="form-group-2">
                    <label for="endorsementPurpose">Purpose:</label>
                    <textarea id="endorsementPurpose" name="purpose" class="form-control-2" rows="3"
                        placeholder="e.g., For business registration, For financial aid"></textarea>
                </div>
                <div class="form-group-2">
                    <label for="businessName">Business Name:</label>
                    <input type="text" id="businessName" name="business_name" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="businessAddress">Business Address:</label>
                    <input type="text" id="businessAddress" name="business_address" class="form-control-2">
                </div>
            </div>

            <div class="form-certificate-specific-fields" data-certificate-type="Barangay Permit"
                style="display: none;">
                <div class="form-group-2">
                    <label for="permitPurpose">Purpose:</label>
                    <textarea id="permitPurpose" name="purpose" class="form-control-2" rows="3"
                        placeholder="e.g., For operating a sari-sari store, For construction"></textarea>
                </div>
                <div class="form-group-2"></div>
            </div>

            <div class="form-certificate-specific-fields" data-certificate-type="Vehicle Clearance"
                style="display: none;">
                <div class="form-group-2">
                    <label for="vehiclePurpose">Purpose:</label>
                    <textarea id="vehiclePurpose" name="purpose" class="form-control-2" rows="3"
                        placeholder="e.g., For vehicle registration, For selling vehicle"></textarea>
                </div>
                <div class="form-group-2">
                    <label for="vehicleType">Vehicle Type:</label>
                    <input type="text" id="vehicleType" name="vehicle_type" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleMake">Vehicle Make:</label>
                    <input type="text" id="vehicleMake" name="vehicle_make" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleColor">Vehicle Color:</label>
                    <input type="text" id="vehicleColor" name="vehicle_color" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleYearModel">Vehicle Year Model:</label>
                    <input type="text" id="vehicleYearModel" name="vehicle_year_model" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehiclePlateNumber">Vehicle Plate Number:</label>
                    <input type="text" id="vehiclePlateNumber" name="vehicle_plate_number" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleBodyNumber">Vehicle Body Number:</label>
                    <input type="text" id="vehicleBodyNumber" name="vehicle_body_number" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleRegistrationNumber">Vehicle Registration Number:</label>
                    <input type="text" id="vehicleRegistrationNumber" name="vehicle_registration_number"
                        class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleMotorNumber">Vehicle Motor Number:</label>
                    <input type="text" id="vehicleMotorNumber" name="vehicle_motor_number" class="form-control-2">
                </div>
                <div class="form-group-2">
                    <label for="vehicleChassisNumber">Vehicle Chassis Number:</label>
                    <input type="text" id="vehicleChassisNumber" name="vehicle_chassis_number" class="form-control-2">
                </div>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn btn-good" id="generateCertificateBtn">Generate Certificate</button>
                <button type="button" id="CloseNewCertificateRequestModalBtn" class="btn btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>