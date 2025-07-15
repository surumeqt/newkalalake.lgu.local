<?php
// file: app/frontdesk/fd_certificate.php
include '../../backend/config/database.config.php';
include '../../backend/helpers/redirects.php';
redirectIfNotLoggedIn();

// In a real application, you'd fetch data here:
// $user_email = $_SESSION['username'];
// $current_page = basename($_SERVER['PHP_SELF']);
// $pdo = (new Connection())->connect();

// Placeholder for fetching certificate statistics and list
// In a real scenario, these would come from your database
$totalCertificates = 150;
$pendingCertificates = 15;
$approvedCertificates = 120;
$rejectedCertificates = 15;

// Dummy data for certificate requests - similar to what you'd get from a DB query
$certificateRequests = [
    [
        'request_id' => 'CERT-001',
        'resident_name' => 'Juan Reyes Dela Cruz Sr.',
        'certificate_type' => 'Barangay Residency',
        'purpose' => 'For school enrollment',
        'date_requested' => '2023-09-01',
        'status' => 'Approved',
        'date_issued' => '2023-09-01',
        'issued_by' => 'John Doe',
        'document_path' => '../../assets/docs/residency_juan.pdf'
    ],
    [
        'request_id' => 'CERT-002',
        'resident_name' => 'Maria Santos Rodriguez',
        'certificate_type' => 'Certificate of Indigency',
        'purpose' => 'For medical assistance',
        'date_requested' => '2024-01-10',
        'status' => 'Pending',
        'date_issued' => null,
        'issued_by' => null,
        'document_path' => null
    ],
    [
        'request_id' => 'CERT-003',
        'resident_name' => 'Pedro Garcia Lim',
        'certificate_type' => 'Barangay Permit',
        'purpose' => 'Business permit application',
        'date_requested' => '2024-03-15',
        'status' => 'Rejected',
        'date_issued' => null,
        'issued_by' => 'Jane Smith',
        'document_path' => null
    ],
    [
        'request_id' => 'CERT-004',
        'resident_name' => 'Juan Reyes Dela Cruz Sr.',
        'certificate_type' => 'Certificate of Indigency',
        'purpose' => 'For job application',
        'date_requested' => '2024-05-20',
        'status' => 'Approved',
        'date_issued' => '2024-05-20',
        'issued_by' => 'John Doe',
        'document_path' => '../../assets/docs/indigency_juan.pdf'
    ],
    [
        'request_id' => 'CERT-005',
        'resident_name' => 'Ana Marie Dela Vega',
        'certificate_type' => 'Barangay Endorsement',
        'purpose' => 'Scholarship application',
        'date_requested' => '2024-06-01',
        'status' => 'Pending',
        'date_issued' => null,
        'issued_by' => null,
        'document_path' => null
    ],
];

// Dummy resident data for the search/select functionality
$allResidents = [
    ['id' => 1, 'full_name' => 'Juan Reyes Dela Cruz Sr.', 'is_banned' => false, 'ban_reason' => ''],
    ['id' => 2, 'full_name' => 'Maria Santos Rodriguez', 'is_banned' => false, 'ban_reason' => ''],
    ['id' => 3, 'full_name' => 'Pedro Garcia Lim', 'is_banned' => true, 'ban_reason' => 'Ignoring Lupon Summons'],
    ['id' => 4, 'full_name' => 'Ana Marie Dela Vega', 'is_banned' => false, 'ban_reason' => ''],
];
?>

<div class="page-content-header">
    <h2>Certificate Management</h2>
    <p class="current-page-title">Manage all resident certificate requests</p>
</div>

<div class="certificate-dashboard-container card">
    <div class="card-body">
        <div class="certificate-stats-cards">
            <div class="stat-card total">
                <h3>Total Requests</h3>
                <p><?php echo $totalCertificates; ?></p>
            </div>
            <div class="stat-card pending">
                <h3>Pending Requests</h3>
                <p><?php echo $pendingCertificates; ?></p>
            </div>
            <div class="stat-card approved">
                <h3>Approved Certificates</h3>
                <p><?php echo $approvedCertificates; ?></p>
            </div>
            <div class="stat-card rejected">
                <h3>Rejected Requests</h3>
                <p><?php echo $rejectedCertificates; ?></p>
            </div>
        </div>

        <div class="action-bar">
            <button id="OpenNewCertificateRequestModalBtn" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Request New Certificate
            </button>
        </div>

        <div class="certificate-filters">
            <input type="text" id="certificateSearch" class="form-control" placeholder="Search by name, ID, or type...">
            <select id="certificateStatusFilter" class="form-control">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <input type="date" id="certificateDateFilter" class="form-control" title="Filter by date requested">
            <button class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
            <button class="btn btn-outline-secondary"><i class="fas fa-redo"></i> Reset</button>
        </div>

        <div class="certificate-table-section table-responsive">
            <h4>All Certificate Requests</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Resident Name</th>
                        <th>Certificate Type</th>
                        <th>Purpose</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                        <th>Date Issued</th>
                        <th>Issued By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($certificateRequests)): ?>
                    <?php foreach ($certificateRequests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['request_id']); ?></td>
                        <td><?php echo htmlspecialchars($request['resident_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['certificate_type']); ?></td>
                        <td><?php echo htmlspecialchars($request['purpose']); ?></td>
                        <td><?php echo htmlspecialchars(date('M d, Y', strtotime($request['date_requested']))); ?></td>
                        <td>
                            <?php
                                        $statusClass = '';
                                        if ($request['status'] == 'Approved') $statusClass = 'status-active';
                                        else if ($request['status'] == 'Pending') $statusClass = 'status-pending';
                                        else if ($request['status'] == 'Rejected' || $request['status'] == 'Cancelled') $statusClass = 'status-inactive';
                                    ?>
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($request['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php echo $request['date_issued'] ? htmlspecialchars(date('M d, Y', strtotime($request['date_issued']))) : 'N/A'; ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($request['issued_by'] ?: 'N/A'); ?>
                        </td>
                        <td class="actions">
                            <?php if ($request['status'] == 'Approved' && $request['document_path']): ?>
                            <a href="<?php echo htmlspecialchars($request['document_path']); ?>" target="_blank"
                                class="btn btn-sm btn-info download-btn" title="Download Document">
                                <i class="fas fa-download"></i>
                            </a>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-primary view-request-btn"
                                data-request-id="<?php echo htmlspecialchars($request['request_id']); ?>"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php if ($request['status'] == 'Pending'): ?>
                            <button class="btn btn-sm btn-success process-request-btn"
                                data-request-id="<?php echo htmlspecialchars($request['request_id']); ?>"
                                title="Process Request">
                                <i class="fas fa-cogs"></i>
                            </button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-danger delete-request-btn"
                                data-request-id="<?php echo htmlspecialchars($request['request_id']); ?>"
                                title="Delete Request">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No certificate requests found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="NewCertificateRequestModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Request New Certificate</h3>
        <form id="newCertificateRequestForm" class="modal-form">
            <div class="form-group-2">
                <label for="residentSearchInput">Search Resident:</label>
                <input type="text" id="residentSearchInput" class="form-control-2"
                    placeholder="Search by name or ID...">
                <div id="residentSearchResults" class="search-results-dropdown">
                </div>
                <input type="hidden" id="selectedResidentId" name="resident_id">
            </div>

            <div id="selectedResidentInfo" class="selected-resident-info">
                <p><strong>Selected Resident:</strong> <span id="residentNameDisplay">N/A</span></p>
                <div id="residentBanWarning" class="alert alert-danger" style="display: none;">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Modals Logic for fd_certificate.php ---

    const openNewCertModalBtn = document.getElementById('OpenNewCertificateRequestModalBtn');
    const newCertRequestModal = document.getElementById('NewCertificateRequestModal');
    const closeNewCertModalBtn = document.getElementById('CloseNewCertificateRequestModalBtn');

    // Open Modal
    if (openNewCertModalBtn) {
        openNewCertModalBtn.addEventListener('click', () => {
            newCertRequestModal.classList.add('active');
        });
    }

    // Close Modal via Cancel button
    if (closeNewCertModalBtn) {
        closeNewCertModalBtn.addEventListener('click', () => {
            newCertRequestModal.classList.remove('active');
            document.getElementById('newCertificateRequestForm').reset(); // Reset form on close
            // Clear resident selection and warnings
            document.getElementById('residentNameDisplay').textContent = 'N/A';
            document.getElementById('selectedResidentId').value = '';
            document.getElementById('residentBanWarning').style.display = 'none';
            document.getElementById('residentSearchInput').value = '';
            document.getElementById('residentSearchResults').innerHTML = '';
            document.getElementById('photoUploadGroup').style.display = 'none'; // Hide photo field
        });
    }

    // Close Modal via overlay click
    if (newCertRequestModal) {
        newCertRequestModal.addEventListener('click', (event) => {
            if (event.target === newCertRequestModal) {
                newCertRequestModal.classList.remove('active');
                document.getElementById('newCertificateRequestForm').reset(); // Reset form on close
                // Clear resident selection and warnings
                document.getElementById('residentNameDisplay').textContent = 'N/A';
                document.getElementById('selectedResidentId').value = '';
                document.getElementById('residentBanWarning').style.display = 'none';
                document.getElementById('residentSearchInput').value = '';
                document.getElementById('residentSearchResults').innerHTML = '';
                document.getElementById('photoUploadGroup').style.display = 'none'; // Hide photo field
            }
        });
    }

    // --- Resident Search and Selection Logic ---
    const residentSearchInput = document.getElementById('residentSearchInput');
    const residentSearchResults = document.getElementById('residentSearchResults');
    const selectedResidentId = document.getElementById('selectedResidentId');
    const residentNameDisplay = document.getElementById('residentNameDisplay');
    const residentBanWarning = document.getElementById('residentBanWarning');
    const banReasonDisplay = document.getElementById('banReasonDisplay');
    const photoUploadGroup = document.getElementById('photoUploadGroup');

    // Dummy resident data (in a real app, this would come from an AJAX call to a backend endpoint)
    const ALL_RESIDENTS_DATA = <?php echo json_encode($allResidents); ?>;

    residentSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        residentSearchResults.innerHTML = ''; // Clear previous results

        if (searchTerm.length > 0) {
            const filteredResidents = ALL_RESIDENTS_DATA.filter(resident =>
                resident.full_name.toLowerCase().includes(searchTerm) ||
                String(resident.id).includes(searchTerm)
            );

            if (filteredResidents.length > 0) {
                filteredResidents.forEach(resident => {
                    const div = document.createElement('div');
                    div.classList.add('search-result-item');
                    div.textContent = `${resident.full_name} (ID: ${resident.id})`;
                    div.dataset.residentId = resident.id;
                    div.dataset.residentName = resident.full_name;
                    div.dataset.isBanned = resident.is_banned;
                    div.dataset.banReason = resident.ban_reason;
                    residentSearchResults.appendChild(div);
                });
                residentSearchResults.style.display = 'block';
            } else {
                residentSearchResults.style.display = 'none';
            }
        } else {
            residentSearchResults.style.display = 'none';
        }
    });

    residentSearchResults.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('search-result-item')) {
            const id = target.dataset.residentId;
            const name = target.dataset.residentName;
            const isBanned = target.dataset.isBanned === 'true';
            const banReason = target.dataset.banReason;

            selectedResidentId.value = id;
            residentNameDisplay.textContent = name;
            residentSearchInput.value = name; // Auto-fill search input

            // Display ban warning if applicable
            if (isBanned) {
                residentBanWarning.style.display = 'block';
                banReasonDisplay.textContent = banReason;
                document.getElementById('generateCertificateBtn').disabled =
                    true; // Disable button if banned
            } else {
                residentBanWarning.style.display = 'none';
                banReasonDisplay.textContent = '';
                document.getElementById('generateCertificateBtn').disabled = false; // Enable button
            }

            residentSearchResults.style.display = 'none'; // Hide results after selection
        }
    });

    // Hide search results when clicking outside
    document.addEventListener('click', function(event) {
        if (!residentSearchInput.contains(event.target) && !residentSearchResults.contains(event
                .target)) {
            residentSearchResults.style.display = 'none';
        }
    });

    // Dynamic photo field display based on certificate type
    const selectCertificateType = document.getElementById('selectCertificateType');
    selectCertificateType.addEventListener('change', function() {
        // Example: If 'Barangay Permit' requires a photo
        if (this.value === 'Barangay Permit' || this.value === 'Vehicle Clearance') {
            photoUploadGroup.style.display = 'block';
        } else {
            photoUploadGroup.style.display = 'none';
            document.getElementById('certificatePhoto').value = ''; // Clear selected file
        }
    });


    // --- Form Submission (example) ---
    const newCertRequestForm = document.getElementById('newCertificateRequestForm');
    if (newCertRequestForm) {
        newCertRequestForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const residentId = document.getElementById('selectedResidentId').value;
            const certificateType = selectCertificateType.value;
            const purpose = document.getElementById('certificatePurpose').value;
            const certificatePhoto = document.getElementById('certificatePhoto').files[
                0]; // Get file object

            if (!residentId || !certificateType || !purpose) {
                alert('Please select a resident and fill in all required fields.');
                return;
            }

            // If a photo is required for the selected certificate type and not provided
            if (photoUploadGroup.style.display === 'block' && !certificatePhoto) {
                alert('A photo is required for this certificate type.');
                return;
            }

            console.log('New Certificate Request Submitted:');
            console.log('Resident ID:', residentId);
            console.log('Certificate Type:', certificateType);
            console.log('Purpose:', purpose);
            if (certificatePhoto) {
                console.log('Photo File:', certificatePhoto.name);
            }

            // In a real application, you would send this data to a backend endpoint
            // e.g., using fetch() or XMLHttpRequest, potentially with FormData for files
            alert('Certificate generation request sent! (Backend would generate and print)');
            newCertRequestModal.classList.remove('active');
            this.reset(); // Reset the form
            // Clear resident selection and warnings after successful submission
            document.getElementById('residentNameDisplay').textContent = 'N/A';
            document.getElementById('selectedResidentId').value = '';
            document.getElementById('residentBanWarning').style.display = 'none';
            document.getElementById('residentSearchInput').value = '';
            document.getElementById('residentSearchResults').innerHTML = '';
            document.getElementById('photoUploadGroup').style.display = 'none'; // Hide photo field
            // You would typically re-fetch and re-render the certificate requests table here
        });
    }

    // --- Table Search/Filter Logic (basic example) ---
    const certificateSearchInput = document.getElementById('certificateSearch');
    const certificateStatusFilter = document.getElementById('certificateStatusFilter');
    const certificateDateFilter = document.getElementById('certificateDateFilter');
    const certificateTableBody = document.querySelector('.certificate-table-section .data-table tbody');

    const filterCertificates = () => {
        const searchTerm = certificateSearchInput.value.toLowerCase();
        const statusFilter = certificateStatusFilter.value;
        const dateFilter = certificateDateFilter.value; // YYYY-MM-DD

        const rows = certificateTableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const residentName = row.children[1].textContent.toLowerCase();
            const certType = row.children[2].textContent.toLowerCase();
            const status = row.children[5].querySelector('.status-badge').textContent.trim();
            const dateRequested = row.children[4].textContent; // e.g., "Sep 01, 2023"

            let isVisible = true;

            // Search term filter
            if (searchTerm && !(residentName.includes(searchTerm) || certType.includes(
                    searchTerm))) {
                isVisible = false;
            }

            // Status filter
            if (statusFilter && status !== statusFilter) {
                isVisible = false;
            }

            // Date filter (simple match for demonstration, can be extended for range)
            if (dateFilter) {
                // Convert displayed date to YYYY-MM-DD for comparison
                const formattedDateRequested = new Date(dateRequested).toISOString().split('T')[0];
                if (formattedDateRequested !== dateFilter) {
                    isVisible = false;
                }
            }

            row.style.display = isVisible ? '' : 'none';
        });
    };

    if (certificateSearchInput) {
        certificateSearchInput.addEventListener('keyup', filterCertificates);
    }
    if (certificateStatusFilter) {
        certificateStatusFilter.addEventListener('change', filterCertificates);
    }
    if (certificateDateFilter) {
        certificateDateFilter.addEventListener('change', filterCertificates);
    }
    // Attach filter to the 'Filter' button as well
    document.querySelector('.certificate-filters .btn-secondary').addEventListener('click', filterCertificates);
    // Reset button
    document.querySelector('.certificate-filters .btn-outline-secondary').addEventListener('click', () => {
        certificateSearchInput.value = '';
        certificateStatusFilter.value = '';
        certificateDateFilter.value = '';
        filterCertificates(); // Apply reset filters
    });
});
</script>

<style>
/* Basic CSS for fd_certificate.php specific elements */
.certificate-dashboard-container {
    padding: 20px;
    background-color: var(--bg-white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-subtle);
}

.certificate-stats-cards {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.stat-card {
    background-color: var(--bg-light);
    border: 1px solid var(--border-light);
    border-radius: var(--border-radius);
    padding: 15px 20px;
    text-align: center;
    flex: 1;
    min-width: 200px;
    box-shadow: var(--shadow-subtle);
}

.stat-card h3 {
    font-size: 1.1em;
    color: var(--light-text);
    margin-bottom: 10px;
}

.stat-card p {
    font-size: 2em;
    font-weight: bold;
    color: var(--dark-text);
}

.stat-card.total p {
    color: var(--primary-blue);
}

.stat-card.pending p {
    color: var(--warning-color);
}

.stat-card.approved p {
    color: var(--success-color);
}

.stat-card.rejected p {
    color: var(--danger-color);
}

.action-bar {
    text-align: right;
    margin-bottom: 20px;
}

.certificate-filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
}

.certificate-filters .form-control {
    flex: 1;
    min-width: 150px;
    max-width: 250px;
}

.certificate-table-section h4 {
    margin-bottom: 15px;
    color: var(--dark-text);
}

.data-table th,
.data-table td {
    padding: 10px 15px;
    vertical-align: middle;
}

.data-table .actions .btn {
    margin-right: 5px;
}

/* Modal Specific Styles (ensure these are consistent with your global modal styles) */
.modal-overlay {
    display: none;
    /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-overlay.active {
    display: flex;
    /* Show when active class is added */
}

.modal-content {
    background-color: var(--bg-white);
    padding: 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-heavy);
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}

.modal-content h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: var(--dark-text);
    text-align: center;
}

.modal-form .form-group-2 {
    margin-bottom: 15px;
    width: 100%;
}

.modal-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: var(--dark-text);
}

.modal-form .form-control-2 {
    width: 100%;
    /* width: 400px; */
    padding: 10px;
    border: 1px solid var(--border-light);
    border-radius: var(--border-radius-sm);
    box-sizing: border-box;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

/* Styles for Resident Search Autocomplete */
.search-results-dropdown {
    border: 1px solid var(--border-light);
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    width: calc(100% - 60px);
    /* Adjust based on modal padding */
    background-color: var(--bg-white);
    z-index: 1001;
    box-shadow: var(--shadow-subtle);
    display: none;
    /* Hidden by default */
    top: calc(80px + 10px + 38px);
    /* Adjust to be below search input (h3 + padding + label height + input height) */
    left: 30px;
    /* Match modal padding */
}

.search-result-item {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid var(--border-light);
}

.search-result-item:hover {
    background-color: var(--bg-light);
}

.search-result-item:last-child {
    border-bottom: none;
}

.selected-resident-info {
    background-color: var(--bg-light);
    border: 1px solid var(--border-light);
    padding: 10px 15px;
    border-radius: var(--border-radius-sm);
    margin-bottom: 20px;
}

.selected-resident-info p {
    margin: 0;
    color: var(--dark-text);
}

.alert {
    padding: 10px 15px;
    margin-top: 10px;
    border-radius: var(--border-radius-sm);
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-danger {
    background-color: #f8d7da;
    /* Light red */
    color: #721c24;
    /* Dark red */
    border-color: #f5c6cb;
}
</style>