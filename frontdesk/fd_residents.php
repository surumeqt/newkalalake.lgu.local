<?php
include '../backend/helpers/redirects.php';
require_once __DIR__ . '/../backend/models/residents.model.php';
redirectIfNotLoggedIn();

$user_username = $_SESSION['username'] ?? 'Guest';
$residentsModel = new Residents();

// --- Pagination Logic ---
$itemsPerPage = 20; // Number of residents to display per page
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
        <form action="../backend/fd_controllers/residents.controller.php" method="POST">
            <div class="search-bar">
                <input type="text" id="residentSearchInput" class="form-control" name="search"
                    placeholder="Search residents..." onkeyup="liveSearch()">
                <button type="button" class="btn btn-primary" onclick="liveSearch()"><i class="fas fa-search"
                        id="residentSearchBtn"></i> Search</button>
            </div>
        </form>
        <button class="btn btn-success add-resident-btn" id="openModalBtn">
            <i class="fas fa-user-plus"></i> Register New Resident
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
                    <?php foreach ($records as $row): // Changed $rows to $row for consistency and clarity 
                        ?>
                    <tr>
                        <td>
                            <div class="table-thumbnail">
                                <i class="fas fa-user-circle default-thumbnail"></i>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix'] ?? ''); ?>
                        </td>
                        <td><?= htmlspecialchars($row['address']); ?></td>
                        <td><?= htmlspecialchars($row['gender']); ?></td>
                        <td><?= htmlspecialchars($row['birthday']); ?></td>
                        <td>Barangay Residency</td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <button id="OpenNewCertificateRequestModalBtn"
                                class="btn btn-sm btn-primary issue-certificate-btn open-new-certificate-modal-btn">
                                <i class="fas fa-file-alt"></i> Issue
                            </button>
                            <button class="btn btn-sm btn-info view-resident-btn" data-url="./fd_resident_profile.php"
                                data-load-content="true"
                                data-resident-id="<?= htmlspecialchars($row['resident_id']); ?>"><i
                                    class="fas fa-eye"></i> View
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
        <h3>Register New Resident</h3>
        <form id="addResidentForm" class="modal-form" action="../backend/fd_controllers/residents.controller.php"
            method="POST" enctype="multipart/form-data">
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
                    <input type="date" id="birthDate" name="birthday" class="form-control" onblur="reflectAge()"
                        required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" class="form-control" required>
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
                    <input type="text" id="houseNumber" name="houseNumber" class="form-control">
                </div>
                <div class="form-group">
                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="purok">Purok/Zone:</label>
                    <input type="text" id="purok" name="purok" class="form-control">
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay:</label>
                    <input type="text" id="barangay" name="barangay" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact No.:</label>
                    <input type="text" id="contact_number" name="contact_number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem; border-top: 1px solid #ccc; padding-top: 1rem;">
                <label for="photo">Resident Photo (Optional):</label>
                <input type="file" id="photo" name="photo" accept="image/*" class="form-control-file">
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-good">Register Resident</button>
                <button type="button" id="closeModalBtn" class="btn btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>
<div id="NewCertificateRequestModal" class="modal-overlay">
    <div class="new-certificate-request-modal-content">
        <h3 style="text-align: center;">Request New Certificate</h3>
        <form id="newCertificateRequestForm" class="modal-form">
            <div class="form-group-2">
                <label for="residentSearchInput">Selected Resident:</label>
                <input type="text" id="residentSearchInput" class="form-control-2" placeholder="Selected Resident"
                    disabled>
                <div id="residentSearchResults" class="search-results-dropdown">
                </div>
                <input type="hidden" id="selectedResidentId" name="resident_id">
            </div>

            <div id="selectedResidentInfo" class="selected-resident-info">
                <p><strong>Selected Resident Status:</strong> <span id="residentNameDisplay"
                        style="display: none;">N/A</span></p>
                <div id="residentBanWarning" class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> This resident is currently <strong
                        class="text-danger">BANNED</strong> from receiving certificates. Reason: <span
                        id="banReasonDisplay"></span>
                </div>
            </div>

            <div class="form-group-2">
                <label for="selectCertificateType">Certificate Type:</label>
                <select id="selectCertificateType" name="certificate_type" class="form-control-2" required>
                    <option value="">-- Select Certificate Type --</option>
                    <option value="Barangay Residency">Barangay Residency</option>
                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                    <option value="Non-Residency Certificate">Certificate of Non-Residency</option>
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
            <div class="form-group-2">
                <label for="certificatePurpose">Purpose:</label>
                <textarea id="certificatePurpose" name="purpose" class="form-control-2" rows="3" required
                    placeholder="e.g., For school enrollment, For job application, For business registration"></textarea>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-good" id="generateCertificateBtn">Generate Certificate</button>
                <button type="button" id="CloseNewCertificateRequestModalBtn" class="btn btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>