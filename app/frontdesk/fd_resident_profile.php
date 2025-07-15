<?php
// file: app/frontdesk/fd_resident_profile.php
// Removed database connection and query for dummy data
include '../../backend/helpers/redirects.php';
// redirectIfNotLoggedIn(); // This can be uncommented if user authentication is needed

// All data is now hardcoded as requested, no need for dummy data arrays or database calls.
?>

<div class="page-content-header">
    <h2>Resident Profile</h2>
    <p class="current-page-title">Juan Reyes Dela Cruz Sr.</p>
</div>

<div class="resident-profile-container card">
    <div class="card-body">
        <div class="profile-header">
            <div class="profile-photo-area">
                <img src="../../assets/img/dummy_resident_male.jpg" alt="Resident Photo" class="profile-photo">
            </div>
            <div class="profile-details-summary">
                <h3>Juan Reyes Dela Cruz Sr.</h3>
                <p><strong>ID:</strong> 1</p>
                <p>
                    <strong>Status:</strong>
                    <span class="status-badge status-active">Active</span>
                </p>
            </div>
        </div>

        <div class="profile-sections">
            <div class="profile-section basic-info-section">
                <h4><i class="fas fa-info-circle"></i> Basic Information</h4>
                <p><strong>Birth Date:</strong> May 10, 1985 (Age: 40)</p>
                <p><strong>Gender:</strong> Male</p>
                <p><strong>Civil Status:</strong> Married</p>
                <p><strong>Contact #:</strong> 09123456789</p>
            </div>

            <div class="profile-section address-info-section">
                <h4><i class="fas fa-map-marker-alt"></i> Address</h4>
                <p><strong>House No:</strong> 123</p>
                <p><strong>Street:</strong> Main Street</p>
                <p><strong>Purok/Zone:</strong> Purok 1</p>
                <p><strong>Barangay:</strong> Olongapo City</p>
            </div>

            <div class="profile-section admin-info-section">
                <h4><i class="fas fa-tools"></i> Administration Info</h4>
                <p><strong>Date Registered:</strong> January 15, 2022 10:30 AM</p>
                <p><strong>Last Updated:</strong> June 1, 2024 02:00 PM</p>
            </div>
        </div>

        <div class="profile-actions-bar">
            <button id="OpenEditResidentModalBtn" class="btn btn-warning edit-resident-btn" data-resident-id="1">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
            <button class="btn btn-primary issue-certificate-btn" data-resident-id="1" id="issueCertificateModalBtn">
                <i class="fas fa-file-alt"></i> Issue Certificate
            </button>
            <button class="btn btn-danger ban-resident-btn" data-resident-id="1">
                <i class="fas fa-ban"></i> Ban Resident
            </button>
            <!-- <button class="btn btn-info print-profile-btn" data-resident-id="1">
                <i class="fas fa-print"></i> Print Profile
            </button> -->
            <button id="deleteResidentModalBtn" class="btn btn-secondary delete-resident-btn" data-resident-id="1">
                <i class="fas fa-trash-alt"></i> Delete Resident
            </button>
        </div>

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
                            <th>Status</th>
                            <th>Document</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Barangay Residency</td>
                            <td>For school enrollment</td>
                            <td>September 1, 2023</td>
                            <td>John Doe</td>
                            <td>
                                <span class="status-badge status-active">
                                    Approved
                                </span>
                            </td>
                            <td>
                                <a href="../../assets/docs/residency_juan.pdf" target="_blank"
                                    class="btn btn-sm btn-info download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Certificate of Indigency</td>
                            <td>For medical assistance</td>
                            <td>January 15, 2024</td>
                            <td>Jane Smith</td>
                            <td>
                                <span class="status-badge status-active">
                                    Approved
                                </span>
                            </td>
                            <td>
                                <a href="../../assets/docs/indigency_juan.pdf" target="_blank"
                                    class="btn btn-sm btn-info download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Barangay Permit</td>
                            <td>Business permit application</td>
                            <td>March 20, 2024</td>
                            <td>John Doe</td>
                            <td>
                                <span class="status-badge status-pending">
                                    Pending
                                </span>
                            </td>
                            <td>
                                N/A
                            </td>
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
                    <label for="barangay">Barangay:</label>
                    <input type="text" id="barangay" name="barangay" class="form-control" value="New Kalalake" readonly
                        required>
                </div>
                <div class="form-group">
                    <label for="contactNumber">Number (Optional):</label>
                    <input type="tel" id="contactNumber" name="contact_number" class="form-control" pattern="[0-9]{11}"
                        placeholder="e.g., 09123456789">
                </div>
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