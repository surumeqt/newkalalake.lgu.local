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
                            <button onclick="window.open('../doctest.php', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/download.png" alt="download">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/preview-file.png" alt="view">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/delete.png" alt="delete">
                                </span>
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
                            <button onclick="window.open('../doctest.php', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/download.png" alt="download">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/preview-file.png" alt="view">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/delete.png" alt="delete">
                                </span>
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
                            <button onclick="window.open('../doctest.php', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/download.png" alt="download">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/preview-file.png" alt="view">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/delete.png" alt="delete">
                                </span>
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
                            <button onclick="window.open('../doctest.php', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/download.png" alt="download">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/preview-file.png" alt="view">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/delete.png" alt="delete">
                                </span>
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
                            <button onclick="window.open('../doctest.php', '_blank')"
                                class="btn-2 btn-sm-2 btn-info download-btn" title="Download Document">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/download.png" alt="download">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-primary view-request-btn" data-request-id="CERT-001"
                                title="View Details">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/preview-file.png" alt="view">
                                </span>
                            </button>
                            <button class="btn-2 btn-sm-2 btn-danger delete-request-btn" data-request-id="CERT-001"
                                title="Delete Request">
                                <span class="btn-img-con-2">
                                    <img class="btn-img" src="images/icons/delete.png" alt="delete">
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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

.certificate-filters .form-control {
    flex: 1;
    min-width: 150px;
    max-width: 300px;
    background-color: var(--bg-light);
}

.certificate-table-section h4 {
    margin-bottom: 15px;
    margin-top: 20px;
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
</style>