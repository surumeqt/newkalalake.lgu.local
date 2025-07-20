<?php
// file: app/frontdesk/fd_certificate.php
include '../backend/config/database.config.php';
include '../backend/helpers/redirects.php';

redirectIfNotLoggedIn(); // This checks if the user is logged in for this specific request.

// Initialize PDO connection for this script
$pdo = (new Connection())->connect();

// Get username from session for display
$user_username = $_SESSION['username'] ?? 'Guest'; // Use a default if not set for some reason
?>

<div class="page-content-header">
    <h2>Certificate Management</h2>
</div>

<div class="certificate-dashboard-container card">
    <div class="card-body">
        <div class="certificate-filters">
            <input type="text" id="certificateSearch" class="form-control" placeholder="Search by name, ID, or type...">
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

                        <th>Date Issued</th>
                        <th>Issued By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CERT-001</td>
                        <td>Juan Reyes Dela Cruz Sr.</td>
                        <td>Barangay Residency</td>
                        <td>For school enrollment</td>
                        <td>Sep 01, 2023</td>

                        <td>Sep 01, 2023</td>
                        <td>John Doe</td>
                        <td class="actions">
                            <button onclick="window.open('../../assets/docs/residency_juan.pdf', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>CERT-002</td>
                        <td>Maria Santos Rodriguez</td>
                        <td>Certificate of Indigency</td>
                        <td>For medical assistance</td>
                        <td>Jan 10, 2024</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td class="actions">
                            <button onclick="window.open('../../assets/docs/residency_juan.pdf', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>CERT-003</td>
                        <td>Pedro Garcia Lim</td>
                        <td>Barangay Permit</td>
                        <td>Business permit application</td>
                        <td>Mar 15, 2024</td>
                        <td>N/A</td>
                        <td>Jane Smith</td>
                        <td class="actions">
                            <button onclick="window.open('../../assets/docs/residency_juan.pdf', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>CERT-004</td>
                        <td>Juan Reyes Dela Cruz Sr.</td>
                        <td>Certificate of Indigency</td>
                        <td>For job application</td>
                        <td>May 20, 2024</td>
                        <td>May 20, 2024</td>
                        <td>John Doe</td>
                        <td class="actions">
                            <button onclick="window.open('../../assets/docs/residency_juan.pdf', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>CERT-005</td>
                        <td>Ana Marie Dela Vega</td>
                        <td>Barangay Endorsement</td>
                        <td>Scholarship application</td>
                        <td>Jun 01, 2024</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td class="actions">
                            <button onclick="window.open('../../assets/docs/residency_juan.pdf', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
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


<style>
/* Basic CSS for fd_certificate.php specific elements */
.certificate-dashboard-container {
    padding: 20px;
    background-color: var(--bg-white);
    border-radius: var(--border-radius-md);
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
    max-width: 300px;
    background-color: var(--bg-light);
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