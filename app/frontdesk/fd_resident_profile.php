<?php
// file: app/frontdesk/fd_resident_profile.php
// Removed database connection and query for dummy data
include '../../backend/helpers/redirects.php';
redirectIfNotLoggedIn();

// --- DUMMY DATA START ---
$residentId = $_GET['id'] ?? 1; // Default to ID 1 for dummy data if not provided

$dummyResidents = [
    1 => [
        'resident_id' => 1,
        'first_name' => 'Juan',
        'middle_name' => 'Reyes',
        'last_name' => 'Dela Cruz',
        'suffix' => 'Sr.',
        'birthday' => '1985-05-10',
        'gender' => 'Male',
        'civil_status' => 'Married',
        'purok_or_zone' => 'Purok 1',
        'street' => 'Main Street',
        'house_number' => '123',
        'barangay' => 'Olongapo City',
        'contact_number' => '09123456789',
        'email' => 'juan.delacruz@example.com',
        'photo_path' => 'assets/img/dummy_resident_male.jpg', // Dummy photo path
        'is_banned' => false,
        'ban_reason' => null,
        'date_registered' => '2022-01-15 10:30:00',
        'last_updated' => '2024-06-01 14:00:00'
    ],
    2 => [
        'resident_id' => 2,
        'first_name' => 'Maria',
        'middle_name' => '',
        'last_name' => 'Santos',
        'suffix' => '',
        'birthday' => '1992-11-22',
        'gender' => 'Female',
        'civil_status' => 'Single',
        'purok_or_zone' => 'Zone 3',
        'street' => 'Pine Avenue',
        'house_number' => '45',
        'barangay' => 'Olongapo City',
        'contact_number' => '09987654321',
        'email' => 'maria.santos@example.com',
        'photo_path' => 'assets/img/dummy_resident_female.jpg', // Dummy photo path
        'is_banned' => true,
        'ban_reason' => 'Violated community guidelines.',
        'date_registered' => '2021-08-01 09:15:00',
        'last_updated' => '2024-05-20 11:30:00'
    ]
];

$dummyCertificates = [
    1 => [ // Certificates for Resident ID 1
        [
            'certificate_id' => 101,
            'resident_id' => 1,
            'certificate_type' => 'Barangay Residency',
            'purpose' => 'For school enrollment',
            'date_issued' => '2023-09-01 10:00:00',
            'issued_by' => 'John Doe',
            'status' => 'Approved',
            'document_path' => 'assets/docs/residency_juan.pdf'
        ],
        [
            'certificate_id' => 102,
            'resident_id' => 1,
            'certificate_type' => 'Certificate of Indigency',
            'purpose' => 'For medical assistance',
            'date_issued' => '2024-01-15 14:30:00',
            'issued_by' => 'Jane Smith',
            'status' => 'Approved',
            'document_path' => 'assets/docs/indigency_juan.pdf'
        ],
        [
            'certificate_id' => 103,
            'resident_id' => 1,
            'certificate_type' => 'Barangay Permit',
            'purpose' => 'Business permit application',
            'date_issued' => '2024-03-20 09:00:00',
            'issued_by' => 'John Doe',
            'status' => 'Pending',
            'document_path' => null
        ],
    ],
    2 => [ // Certificates for Resident ID 2
        [
            'certificate_id' => 201,
            'resident_id' => 2,
            'certificate_type' => 'Vehicle Clearance',
            'purpose' => 'Vehicle registration',
            'date_issued' => '2023-07-05 11:00:00',
            'issued_by' => 'Jane Smith',
            'status' => 'Approved',
            'document_path' => 'assets/docs/vehicle_maria.pdf'
        ]
    ]
];


$resident = $dummyResidents[$residentId] ?? null;
$certificates = $dummyCertificates[$residentId] ?? [];
$errorMessage = '';

if (!$resident) {
    $errorMessage = "Dummy resident with ID " . htmlspecialchars($residentId) . " not found. Displaying default dummy resident.";
    $resident = $dummyResidents[1]; // Fallback to a default dummy resident
    $certificates = $dummyCertificates[1]; // Fallback to certificates of default dummy resident
}

// --- DUMMY DATA END ---

// Helper function to calculate age (simple, assumes birthday is in YYYY-MM-DD)
function calculateAge($birthDate)
{
    if (empty($birthDate)) return 'N/A';
    $birthDate = new DateTime($birthDate);
    $today = new DateTime('today');
    $age = $birthDate->diff($today)->y;
    return $age;
}

// Construct full name for display
$fullName = '';
if ($resident) {
    $fullName = htmlspecialchars($resident['first_name'] . ' ' . ($resident['middle_name'] ? $resident['middle_name'] . ' ' : '') . $resident['last_name'] . ($resident['suffix'] ? ' ' . $resident['suffix'] : ''));
}
?>

<div class="page-content-header">
    <h2>Resident Profile</h2>
    <?php if ($resident): ?>
    <p class="current-page-title"><?php echo $fullName; ?></p>
    <?php else: ?>
    <p class="current-page-title">Loading Profile...</p>
    <?php endif; ?>
</div>

<div class="resident-profile-container card">
    <?php if ($errorMessage): ?>
    <div class="alert alert-warning"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <?php if ($resident): ?>
    <div class="card-body">
        <div class="profile-header">
            <div class="profile-photo-area">
                <?php
                    $photoPath = '../../' . $resident['photo_path'];
                    if (!empty($resident['photo_path']) && file_exists($photoPath)): ?>
                <img src="<?php echo htmlspecialchars($photoPath); ?>" alt="Resident Photo" class="profile-photo">
                <?php else: ?>
                <i class="fas fa-user-circle default-profile-icon"></i>
                <?php endif; ?>
            </div>
            <div class="profile-details-summary">
                <h3><?php echo $fullName; ?></h3>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($resident['resident_id']); ?></p>
                <p>
                    <strong>Status:</strong>
                    <?php if ($resident['is_banned']): ?>
                    <span class="status-badge status-inactive">Banned</span>
                    <?php else: ?>
                    <span class="status-badge status-active">Active</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="profile-sections">
            <div class="profile-section basic-info-section">
                <h4><i class="fas fa-info-circle"></i> Basic Information</h4>
                <p><strong>Birth Date:</strong>
                    <?php echo htmlspecialchars(date('F j, Y', strtotime($resident['birthday']))); ?> (Age:
                    <?php echo calculateAge($resident['birthday']); ?>)</p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($resident['gender']); ?></p>
                <p><strong>Civil Status:</strong> <?php echo htmlspecialchars($resident['civil_status']); ?></p>
                <p><strong>Contact #:</strong> <?php echo htmlspecialchars($resident['contact_number'] ?: 'N/A'); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($resident['email'] ?: 'N/A'); ?></p>
            </div>

            <div class="profile-section address-info-section">
                <h4><i class="fas fa-map-marker-alt"></i> Address</h4>
                <p><strong>House No:</strong> <?php echo htmlspecialchars($resident['house_number']); ?></p>
                <p><strong>Street:</strong> <?php echo htmlspecialchars($resident['street']); ?></p>
                <p><strong>Purok/Zone:</strong> <?php echo htmlspecialchars($resident['purok_or_zone'] ?: 'N/A'); ?></p>
                <p><strong>Barangay:</strong> <?php echo htmlspecialchars($resident['barangay']); ?></p>
            </div>

            <div class="profile-section admin-info-section">
                <h4><i class="fas fa-tools"></i> Administration Info</h4>
                <p><strong>Date Registered:</strong>
                    <?php echo htmlspecialchars(date('F j, Y h:i A', strtotime($resident['date_registered']))); ?></p>
                <p><strong>Last Updated:</strong>
                    <?php echo htmlspecialchars(date('F j, Y h:i A', strtotime($resident['last_updated']))); ?></p>
                <?php if ($resident['is_banned']): ?>
                <p><strong>Ban Reason:</strong>
                    <?php echo htmlspecialchars($resident['ban_reason'] ?: 'No reason provided.'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="profile-actions-bar">
            <button class="btn btn-warning edit-resident-btn"
                data-resident-id="<?php echo $resident['resident_id']; ?>">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
            <button class="btn btn-primary issue-certificate-btn"
                data-resident-id="<?php echo $resident['resident_id']; ?>" id="issueCertificateModalBtn">
                <i class="fas fa-file-alt"></i> Issue Certificate
            </button>
            <?php if ($resident['is_banned']): ?>
            <button class="btn btn-success unban-resident-btn"
                data-resident-id="<?php echo $resident['resident_id']; ?>">
                <i class="fas fa-check-circle"></i> Unban Resident
            </button>
            <?php else: ?>
            <button class="btn btn-danger ban-resident-btn" data-resident-id="<?php echo $resident['resident_id']; ?>">
                <i class="fas fa-ban"></i> Ban Resident
            </button>
            <?php endif; ?>
            <button class="btn btn-info print-profile-btn" data-resident-id="<?php echo $resident['resident_id']; ?>">
                <i class="fas fa-print"></i> Print Profile
            </button>
            <button class="btn btn-secondary delete-resident-btn"
                data-resident-id="<?php echo $resident['resident_id']; ?>">
                <i class="fas fa-trash-alt"></i> Delete Resident
            </button>
        </div>

        <div class="profile-section issued-certificates-section">
            <h4><i class="fas fa-certificate"></i> Issued Certificates History</h4>
            <?php if (!empty($certificates)): ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Certificate Type</th>
                            <th>Purpose</th>
                            <th>Date Issued</th>
                            <th>Issued By</th>
                            <th>Status</th>
                            <th>Document</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificates as $cert): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cert['certificate_type']); ?></td>
                            <td><?php echo htmlspecialchars($cert['purpose']); ?></td>
                            <td><?php echo htmlspecialchars(date('F j, Y', strtotime($cert['date_issued']))); ?></td>
                            <td><?php echo htmlspecialchars($cert['issued_by']); ?></td>
                            <td>
                                <span class="status-badge
                                                <?php
                                                if ($cert['status'] == 'Approved') echo 'status-active';
                                                else if ($cert['status'] == 'Pending') echo 'status-pending';
                                                else if ($cert['status'] == 'Rejected' || $cert['status'] == 'Cancelled') echo 'status-inactive';
                                                ?>">
                                    <?php echo htmlspecialchars($cert['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                            $docPath = '../../' . $cert['document_path'];
                                            if (!empty($cert['document_path']) && file_exists($docPath)): ?>
                                <a href="<?php echo htmlspecialchars($docPath); ?>" target="_blank"
                                    class="btn btn-sm btn-info download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <?php else: ?>
                                N/A
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-center">No certificates issued to this resident yet.</p>
            <?php endif; ?>
        </div>

    </div>
    <?php endif; ?>
</div>

<div id="AddresidentModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Register New Resident</h3>
        <form id="addResidentForm" class="modal-form">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="middleName">Middle Name (Optional):</label>
                <input type="text" id="middleName" name="middle_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="suffix">Suffix (Optional):</label>
                <input type="text" id="suffix" name="suffix" class="form-control" placeholder="e.g., Jr., Sr., III">
            </div>
            <div class="form-group">
                <label for="birthDate">Date of Birth:</label>
                <input type="date" id="birthDate" name="birthday" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
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
            <div class="form-group">
                <label for="houseNumber">House No.:</label>
                <input type="text" id="houseNumber" name="houseNumber" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="purokOrZone">Purok/Zone (Optional):</label>
                <input type="text" id="purokOrZone" name="purok_or_zone" class="form-control">
            </div>
            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <input type="text" id="barangay" name="barangay" class="form-control" value="Olongapo City" readonly
                    required>
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number (Optional):</label>
                <input type="tel" id="contactNumber" name="contact_number" class="form-control" pattern="[0-9]{11}"
                    placeholder="e.g., 09123456789">
            </div>
            <div class="form-group">
                <label for="email">Email (Optional):</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="photo">Resident Photo (Optional):</label>
                <input type="file" id="photo" name="photo" accept="image/*" class="form-control-file">
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-confirm">Register Resident</button>
                <button type="button" id="closeModalBtn" class="btn btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="SelectCertificateTypeModal" class="modal-overlay">
    <div class="select-certificate-modal-content">
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
            <button type="button" class="btn btn-cancel close-select-cert-modal-btn">Cancel</button>
        </div>
    </div>
</div>