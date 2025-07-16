<?php
// file: app/frontdesk/fd_residents.php
include '../backend/config/database.config.php';
include '../backend/helpers/redirects.php';
redirectIfNotLoggedIn();

// Initialize PDO connection for this script
$pdo = (new Connection())->connect();

// Get username from session for display (if used on this page)
$user_username = $_SESSION['username'] ?? 'Guest';
?>

<div class="page-content-header">
    <h2>Resident Management</h2>
    <div class="header-actions">
        <div class="search-bar">
            <input type="text" id="residentSearch" class="form-control" placeholder="Search residents...">
            <button class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
        </div>
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
                <tbody>
                    <tr>
                        <td>
                            <div class="table-thumbnail">
                                <i class="fas fa-user-circle default-thumbnail"></i>
                            </div>
                        </td>
                        <td>Juan Dela Cruz</td>
                        <td>123 Main St, Brgy. Central</td>
                        <td>Male</td>
                        <td>1995-01-15</td>
                        <td>Barangay Residency</td>
                        <td>2024-06-20</td>

                        <td>
                            <button id="OpenNewCertificateRequestModalBtn"
                                class="btn btn-sm btn-primary issue-certificate-btn">
                                <i class="fas fa-file-alt"></i> Issue
                            </button>
                            <button class="btn btn-sm btn-info view-resident-btn" data-url="./fd_resident_profile.php"
                                data-load-content="true"><i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="table-thumbnail">
                                <i class="fas fa-user-circle default-thumbnail"></i>
                            </div>
                        </td>
                        <td>Maria Clara</td>
                        <td>456 Side St, Brgy. East</td>
                        <td>Female</td>
                        <td>1999-07-22</td>
                        <td>Vehicle Clearance</td>
                        <td>2024-05-10</td>
                        <td>
                            <button id="issueCertificateModalBtn" class="btn btn-sm btn-primary issue-certificate-btn">
                                <i class="fas fa-file-alt"></i> Issue
                            </button>
                            <button class="btn btn-sm btn-info view-resident-btn" data-url="./fd_resident_profile.php"
                                data-load-content="true"><i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="table-thumbnail">
                                <i class="fas fa-user-circle default-thumbnail"></i>
                            </div>
                        </td>
                        <td>Pedro Penduko</td>
                        <td>789 Old Rd, Brgy. West</td>
                        <td>Male</td>
                        <td>1980-03-01</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>
                            <button id="issueCertificateModalBtn" class="btn btn-sm btn-primary issue-certificate-btn">
                                <i class="fas fa-file-alt"></i> Issue
                            </button>
                            <button class="btn btn-sm btn-info view-resident-btn" data-url="./fd_resident_profile.php"
                                data-load-content="true"><i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-pagination">
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link">2</a>
            <a href="#" class="page-link">3</a>
            <a href="#" class="page-link">Next &raquo;</a>
        </div>
    </div>
</div>

<div id="AddresidentModal" class="modal-overlay">
    <div class="add-resident-modal-content">
        <h3>Register New Resident</h3>
        <form id="addResidentForm" class="modal-form">
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
            </div>

            <div class="form-group">
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
        <h3>Request New Certificate</h3>
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
<div id="SelectCertificateTypeModal" class="modal-overlay">
    <div class="select-certificate-modal-content">
        <h3>Select Certificate Type</h3>
        <!-- these btn will open another modal for each seperate modal -->
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
            <button type="button" id="sc-closeModalBtn" class="btn btn-confirm">Cancel</button>
        </div>
    </div>
</div>