<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../backend/helpers/redirects.php';
    redirectIfNotLoggedIn();
    $user_email = $_SESSION['username']; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU - Brgy. New Kalalake System</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="css/app.frontdesk.css">
    <link rel="stylesheet" href="css/modal.style.css">
</head>

<body>
    <div id="notification-toast" class="notification-toast">

    </div>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo-area">
                <img class="brgy_logo" src="images/logo.png" alt="Logo">
                <h1>Brgy. New Kalalake</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="./fd_dashboard.php" data-load-content="true">Dashboard</a></li>
                    <li><a href="./fd_residents.php" data-load-content="true">Residents</a></li>
                    <li><a href="./fd_certificate.php" data-load-content="true">Certificate</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <p class="user-email-display"><?php echo htmlspecialchars($user_email); ?></p>
                <button id="logoutButton" class="logout-btn">Logout</button>
            </div>
        </aside>

        <div class="sidebar-overlay"></div>

        <div class="main-panel">
            <header class="top-bar">
                <button class="menu-toggle" aria-label="Toggle Menu">&#9776;</button>
                <h2 class="current-page-title">Dashboard</h2>
                <span class="user-greeting">Welcome, <?php echo htmlspecialchars($user_email); ?></span>
            </header>
            <div class="content-display">
                <p>Loading Dashboard...</p>
                <!-- insert contents here dynamically -->
            </div>
        </div>
    </div>

    <!-- MODALS -->

    <!-- logout Modal -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Confirm Logout</h3>
            <p>Are you sure you want to log out?</p>
            <div class="modal-actions">
                <button id="confirmLogout" class="btn btn-confirm">Yes, Logout</button>
                <button id="cancelLogout" class="btn btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Add Resident Modal -->
    <div id="add-resident-modal">
        <div id="modal-content-wrapper">
            <!-- Modal Header -->
            <div class="modal-header">
                <h2 class="modal-title">Register New Resident</h2>
            </div>
            <form id="addResidentForm" class="modal-form" action="../backend/fd_controllers/resident.controller.php"
                method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-divider">
                        <h3 class="section-title">Personal Information</h3>
                        <div class="grid-4">

                            <div class="form-group">
                                <label for="firstName" class="field-label">
                                    First Name <span class="required">*</span>
                                </label>
                                <input type="text" id="firstName" name="first_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="middleName" class="field-label">Middle Name / Initial </label>
                                <input type="text" id="middleName" name="middle_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lastName" class="field-label">
                                    Last Name <span class="required">*</span>
                                </label>
                                <input type="text" id="lastName" name="last_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="suffix" class="field-label">Suffix:</label>
                                <input type="text" id="suffix" name="suffix" class="form-control"
                                    placeholder="e.g., Jr., Sr., III">
                            </div>
                        </div>
                        <div class="grid-4">

                            <div class="form-group">
                                <label for="birthDate" class="field-label">
                                    Date of Birth <span class="required">*</span>
                                </label>
                                <input type="date" id="birthDate" name="birthday" class="form-control" required
                                    onchange="reflectAge()">
                            </div>
                            <div class="form-group">
                                <label for="age" class="field-label">Age</label>
                                <input type="number" id="age" name="age" class="form-control readonly"
                                    placeholder="Auto Generated" required>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="field-label">
                                    Gender <span class="required">*</span>
                                </label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="civilStatus" class="field-label">
                                    Civil Status <span class="required">*</span>
                                </label>
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
                    <div class="form-divider">
                        <h3 class="section-title">Address Information</h3>
                        <!-- Address Row 1 -->
                        <div class="grid-3">

                            <div class="form-group">
                                <label for="houseNumber" class="field-label">
                                    House No. <span class="required">*</span>
                                </label>
                                <input type="text" id="houseNumber" name="houseNumber" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="street" class="field-label">
                                    Street <span class="required">*</span>
                                </label>
                                <input type="text" id="street" name="street" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="purok" class="field-label">
                                    Purok / Zone
                                </label>
                                <input type="text" id="purok" name="purok" class="form-control">
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label for="barangay" class="field-label">
                                    Barangay <span class="required">*</span>
                                </label>
                                <input type="text" id="barangay" name="barangay" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="city" class="field-label">
                                    City <span class="required">*</span>
                                </label>
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
                                <input type="tel" id="contact_number" name="contact" class="form-control"
                                    placeholder="+63 XXX XXX XXXX">
                            </div>
                            <div class="form-group">
                                <label for="email" class="field-label">
                                    Email Address <span class="optional">(Optional)</span>
                                </label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="example@email.com">
                            </div>
                        </div>
                    </div>
                    <!-- Photo Upload Section -->
                    <div class="form-divider">
                        <h3 class="section-title">Resident Photo Upload</h3>
                        <div class="form-group">
                            <label class="field-label" for="photo">Resident Photo (Optional)</label>
                            <input type="file" id="photo" name="file_upload[]" accept="image/*"
                                class="form-control-file">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                    <button type="submit">Add Resident</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Resident Modal -->
    <div id="edit-resident-modal">
        <div class="edit-resident-modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Resident Profile</h1>
                <button class="close-modal-btn" type="button" onclick="closeEditModal()">
                    &times;
                </button>
            </div>

            <!-- Loader element matching functions.js -->
            <div id="modal-loader" class="modal-loader">
                <div class="spinner"></div>
                <p>Loading resident data...</p>
            </div>

            <!-- Form element now has id="edit-resident-form" and is initially hidden -->
            <form action="../backend/fd_controllers/update.resident.controller.php" method="POST"
                class="edit-modal-form" id="edit-resident-form">
                <div class="resident-profile-sections">
                    <div class="top-info-row">
                        <div class="profile-section profile-summary">
                            <div class="profile-header-content">
                                <div class="profile-image">
                                    <img src="images/logo.png" alt="user" />
                                </div>
                                <div class="profile-meta-info">
                                    <p><strong>ID:</strong><input type="text" class="profile-id"
                                            id="resident-id-display" name="resident_id" readonly></p>
                                    <p><strong>Status:</strong> <span class="profile-status">Not Banned</span></p>
                                    <p><strong>Date Registered:</strong> <span>january 1, 2000</span></p>
                                    <p><strong>Last Updated:</strong> <span>january 1, 2000</span></p>
                                </div>
                            </div>
                            <div class="basic-info-section">
                                <h4 class="info-header info-header-2">
                                    <img class="btn-img" src="images/icons/info-circle.png" alt="info" />
                                    Personal Information
                                </h4>
                                <div class="form-group-grid">
                                    <div class="info-group">
                                        <label for="editFirstName"><strong>First Name</strong></label>
                                        <input type="text" id="editFirstName" name="editFirstName" class="input-control"
                                            placeholder="First Name" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editMiddleName"><strong>Middle Name</strong></label>
                                        <input type="text" id="editMiddleName" name="editMiddleName"
                                            class="input-control" placeholder="Middle Name" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editLastName"><strong>Last Name</strong></label>
                                        <input type="text" id="editLastName" name="editLastName" class="input-control"
                                            placeholder="Last Name" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editSuffix"><strong>Suffix</strong></label>
                                        <input type="text" id="editSuffix" name="editSuffix" class="input-control"
                                            placeholder="e.g., Jr., Sr., III" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editBirthDate"><strong>Birth Date</strong></label>
                                        <input type="date" id="editBirthDate" name="editBirthDate" class="input-control"
                                            onchange="reflectEditAge()" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editAge"><strong>Age</strong></label>
                                        <input type="text" id="editAge" name="editAge" class="input-control readonly"
                                            placeholder="Auto Generated" required />
                                    </div>
                                    <div class="info-group">
                                        <label for="editGender"><strong>Gender</strong></label>
                                        <select id="editGender" name="editGender" class="input-control" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="info-group">
                                        <label for="editCivilStatus"><strong>Civil Status</strong></label>
                                        <select id="editCivilStatus" name="editCivilStatus" class="input-control"
                                            required>
                                            <option value="">Select Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Separated">Separated</option>
                                            <option value="Annulled">Annulled</option>
                                        </select>
                                    </div>
                                    <div class="info-group">
                                        <label for="editIsDeceased"><strong>Resident Status</strong></label>
                                        <select id="editIsDeceased" name="editIsDeceased" class="input-control"
                                            onchange="toggleDeceasedDate('resident')">
                                            <option value="false">Alive</option>
                                            <option value="true">Deceased</option>
                                        </select>
                                    </div>

                                    <!-- NEW: Deceased Date for Resident -->
                                    <div class="info-group" id="editDeceasedDateContainer" style="display: none;">
                                        <label for="editDeceasedDate"><strong>Date of Decease</strong></label>
                                        <input type="date" id="editDeceasedDate" name="editDeceasedDate"
                                            class="input-control" />
                                    </div>

                                    <div class="info-group">
                                        <label for="editAddress"><strong>Address</strong></label>
                                        <input type="text" id="editAddress" name="editAddress" class="input-control"
                                            placeholder="Address" required />
                                    </div>
                                    <div class="info-group">
                                        <label for="editEducationalAttainment"><strong>Educational
                                                Attainment</strong></label>
                                        <select id="editEducationalAttainment" name="editEducationalAttainment"
                                            class="input-control" required>
                                            <option value="">Select Attainment</option>
                                            <option value="N/A">N/A (Not Applicable / Not Graduated)</option>
                                            <option value="No Formal Education">No Formal Education</option>
                                            <option value="Elementary Graduate">Elementary Graduate</option>
                                            <option value="High School Graduate">High School Graduate</option>
                                            <option value="Senior High School Graduate">Senior High School Graduate
                                            </option>
                                            <option value="Vocational Graduate">Vocational Graduate</option>
                                            <option value="College Level">College Level</option>
                                            <option value="College Graduate">College Graduate</option>
                                            <option value="Post-Graduate">Post-Graduate (Master's, Doctorate, etc.)
                                            </option>
                                        </select>
                                        <small class="field-note">Select "N/A" if not graduated from any level.</small>
                                    </div>
                                    <div class="info-group">
                                        <label for="editOccupation"><strong>Occupation</strong></label>
                                        <select name="editOccupation" id="editOccupation" class="input-control"
                                            onchange="toggleOccupationVisibility()">
                                            <option value="">Select Occupation</option>
                                            <option value="Student">Student</option>
                                            <option value="Employed">Employed</option>
                                            <option value="Unemployed">Unemployed</option>
                                        </select>
                                    </div>
                                    <div class="info-group" id="editJobTitleContainer" style="display: none;">
                                        <label for="editjobTitle"><strong>Job Title</strong></label>
                                        <input type="text" id="editjobTitle" name="editjobTitle"
                                            class="input-control"></label>
                                    </div>
                                    <!-- Monthly Income -->
                                    <div class="info-group" id="editMonthlyIncomeContainer" style="display: none;">
                                        <label for="editMonthlyIncome"><strong>Monthly Income</strong></label>
                                        <input type="text" id="editMonthlyIncome" name="editMonthlyIncome"
                                            class="input-control" placeholder="0.00" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editContactNo"><strong>Contact No.</strong></label>
                                        <input type="tel" id="editContactNo" name="editContactNo" class="input-control"
                                            placeholder="+63 XXX XXX XXXX" />
                                    </div>
                                    <div class="info-group">
                                        <label for="editEmail"><strong>Email</strong></label>
                                        <input type="email" id="editEmail" name="editEmail" class="input-control"
                                            placeholder="RwNwI@example.com" />
                                    </div>
                                </div>
                                <h3 style="margin-top: 30px;">Emergency Contact</h3>
                                <div class="emergency-contact-container grid-three-columns">
                                    <div class="info-group">
                                        <label for="editEmergencyContactName"><strong>Name</strong></label>
                                        <input type="text" id="editEmergencyContactName" name="editEmergencyContactName"
                                            class="input-control">
                                    </div>
                                    <div class="info-group">
                                        <label for="editEmergencyContactRelationship"><strong>Relationship</strong>
                                        </label>
                                        <input type="text" id="editEmergencyContactRelationship"
                                            name="editEmergencyContactRelationship" class="input-control">
                                    </div>
                                    <div class="info-group">
                                        <label for="editEmergencyContactNo"><strong>Contact No.</strong></label>
                                        <input type="tel" id="editEmergencyContactNo" name="editEmergencyContactNo"
                                            class="input-control" placeholder="+63 XXX XXX XXXX">
                                    </div>
                                </div>
                                <div class="have-a-business-container">
                                    <div class="info-group">
                                        <h3>Have a Business?</h3>

                                        <div class="radio-group">
                                            <div class="radio-item">
                                                <input type="radio" name="haveABusiness" value="true"
                                                    id="haveABusinessYes" onclick="toggleBusinessVisibility()">
                                                <label for="haveABusinessYes">Yes</label>
                                            </div>
                                            <div class="radio-item">
                                                <input type="radio" name="haveABusiness" value="false"
                                                    id="haveABusinessNo" onclick="toggleBusinessVisibility()">
                                                <label for="haveABusinessNo">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="zxcv" id="zxcv" style="display: none;">
                                        <div class="info-group">
                                            <label for="editBusinessName"><strong>Business Name</strong></label>
                                            <input type="text" id="editBusinessName" name="editBusinessName"
                                                class="input-control" />
                                        </div>
                                        <div class="info-group">
                                            <label for="editBusinessAddress"><strong>Business Address</strong></label>
                                            <input type="text" id="editBusinessAddress" name="editBusinessAddress"
                                                class="input-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-section family-info-section">
                            <h4 class="info-header info-header-2">
                                <img class="btn-img" src="images/icons/family.png" alt="family" />
                                Family Background
                            </h4>
                            <h3>Father's Profile</h3>
                            <div class="form-group-grid two-columns">
                                <div class="info-group">
                                    <label for="editFatherFirstName"><strong>First Name</strong></label>
                                    <input type="text" id="editFatherFirstName" name="editFatherFirstName"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editFatherMiddleName"><strong>Middle Name</strong></label>
                                    <input type="text" id="editFatherMiddleName" name="editFatherMiddleName"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editFatherLastName"><strong>Last Name</strong></label>
                                    <input type="text" id="editFatherLastName" name="editFatherLastName"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editFatherSuffix"><strong>Suffix</strong></label>
                                    <input type="text" id="editFatherSuffix" name="editFatherSuffix"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editFatherBirthDate"><strong>Birth Date</strong></label>
                                    <input type="date" id="editFatherBirthDate" name="editFatherBirthDate"
                                        class="input-control" onchange="reflectFatherAge()" />
                                </div>
                                <div class="info-group">
                                    <label for="editFatherAge"><strong>Age</strong></label>
                                    <input type="text" id="editFatherAge" name="editFatherAge"
                                        class="input-control readonly" placeholder="Auto Generated" required />
                                </div>
                                <div class="info-group">
                                    <label for="editFatherOccupation"><strong>Occupation</strong></label>
                                    <select name="editFatherOccupation" id="editFatherOccupation" class="input-control">
                                        <option value="">Select Occupation</option>
                                        <option value="Student">Student</option>
                                        <option value="Employed">Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                    </select>
                                </div>
                                <div class="info-group">
                                    <label for="editFatherIsDeceased"><strong>Father Status</strong></label>
                                    <select id="editFatherIsDeceased" name="editFatherIsDeceased" class="input-control"
                                        onchange="toggleDeceasedDate('father')">
                                        <option value="false">Alive</option>
                                        <option value="true">Deceased</option>
                                    </select>
                                </div>

                                <!-- NEW: Deceased Date for Father -->
                                <div class="info-group" id="editFatherDeceasedDateContainer" style="display: none;">
                                    <label for="editFatherDeceasedDate"><strong>Date of Decease</strong></label>
                                    <input type="date" id="editFatherDeceasedDate" name="editFatherDeceasedDate"
                                        class="input-control" />
                                </div>

                                <div class="info-group">
                                    <label for="editFatherEducationalAttainment"><strong>Educational
                                            Attainment</strong></label>
                                    <select id="editFatherEducationalAttainment" name="editFatherEducationalAttainment"
                                        class="input-control">
                                        <option value="">Select Attainment</option>
                                        <option value="N/A">N/A (Not Applicable / Not Graduated)</option>
                                        <option value="No Formal Education">No Formal Education</option>
                                        <option value="Elementary Graduate">Elementary Graduate</option>
                                        <option value="High School Graduate">High School Graduate</option>
                                        <option value="Senior High School Graduate">Senior High School Graduate</option>
                                        <option value="Vocational Graduate">Vocational Graduate</option>
                                        <option value="College Level">College Level</option>
                                        <option value="College Graduate">College Graduate</option>
                                        <option value="Post-Graduate">Post-Graduate (Master's, Doctorate, etc.)</option>
                                    </select>
                                    <small class="field-note">Select "N/A" if not graduated from any level.</small>
                                </div>
                                <div class="info-group">
                                    <label for="editFatherContactNo"><strong>Contact No.</strong></label>
                                    <input type="tel" id="editFatherContactNo" name="editFatherContactNo"
                                        class="input-control" placeholder="+63 XXX XXX XXXX" />
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">Mother's Profile</h3>
                            <div class="form-group-grid two-columns">
                                <div class="info-group">
                                    <label for="editMotherFirstName"><strong>First Name</strong></label>
                                    <input type="text" id="editMotherFirstName" name="editMotherFirstName"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editMotherMiddleName"><strong>Middle Name</strong></label>
                                    <input type="text" id="editMotherMiddleName" name="editMotherMiddleName"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editMotherLastName"><strong>Last Name</strong></label>
                                    <input type="text" id="editMotherLastName" name="editMotherLastName"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editMotherSuffix"><strong>Suffix</strong></label>
                                    <input type="text" id="editMotherSuffix" name="editMotherSuffix"
                                        class="input-control" />
                                </div>
                                <div class="info-group">
                                    <label for="editMotherBirthDate"><strong>Birth Date</strong></label>
                                    <input type="date" id="editMotherBirthDate" name="editMotherBirthDate"
                                        class="input-control" onchange="reflectMotherAge()" />
                                </div>
                                <div class="info-group">
                                    <label for="editMotherAge"><strong>Age</strong></label>
                                    <input type="text" id="editMotherAge" name="editMotherAge"
                                        class="input-control readonly" placeholder="Auto Generated" required />
                                </div>
                                <div class="info-group">
                                    <label for="editMotherOccupation"><strong>Occupation</strong></label>
                                    <select name="editMotherOccupation" id="editMotherOccupation" class="input-control">
                                        <option value="">Select Occupation</option>
                                        <option value="Student">Student</option>
                                        <option value="Employed">Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                    </select>
                                </div>
                                <div class="info-group">
                                    <label for="editMotherIsDeceased"><strong>Mother Status</strong></label>
                                    <select id="editMotherIsDeceased" name="editMotherIsDeceased" class="input-control"
                                        onchange="toggleDeceasedDate('mother')">
                                        <option value="false">Alive</option>
                                        <option value="true">Deceased</option>
                                    </select>
                                </div>

                                <!-- NEW: Deceased Date for Mother -->
                                <div class="info-group" id="editMotherDeceasedDateContainer" style="display: none;">
                                    <label for="editMotherDeceasedDate"><strong>Date of Decease</strong></label>
                                    <input type="date" id="editMotherDeceasedDate" name="editMotherDeceasedDate"
                                        class="input-control" />
                                </div>

                                <div class="info-group">
                                    <label for="editMotherEducationalAttainment"><strong>Educational
                                            Attainment</strong></label>
                                    <select id="editMotherEducationalAttainment" name="editMotherEducationalAttainment"
                                        class="input-control">
                                        <option value="">Select Attainment</option>
                                        <option value="N/A">N/A (Not Applicable / Not Graduated)</option>
                                        <option value="No Formal Education">No Formal Education</option>
                                        <option value="Elementary Graduate">Elementary Graduate</option>
                                        <option value="High School Graduate">High School Graduate</option>
                                        <option value="Senior High School Graduate">Senior High School Graduate</option>
                                        <option value="Vocational Graduate">Vocational Graduate</option>
                                        <option value="College Level">College Level</option>
                                        <option value="College Graduate">College Graduate</option>
                                        <option value="Post-Graduate">Post-Graduate (Master's, Doctorate, etc.)</option>
                                    </select>
                                    <small class="field-note">Select "N/A" if not graduated from any level.</small>
                                </div>
                                <div class="info-group">
                                    <label for="editMotherContactNo"><strong>Contact No.</strong></label>
                                    <input type="tel" id="editMotherContactNo" name="editMotherContactNo"
                                        class="input-control" placeholder="+63 XXX XXX XXXX" />
                                </div>
                            </div>
                            <h3>Brothers and Sisters</h3>
                            <div class="siblings-container grid-three-columns">
                                <!-- number of broders -->
                                <div class="info-group">
                                    <label for="editBrothers"><strong>Number of Brothers</strong></label>
                                    <input type="number" id="editBrothers" name="editBrothers" class="input-control"
                                        min="0" />
                                </div>
                                <!-- number of sisters -->
                                <div class="info-group">
                                    <label for="editSisters"><strong>Number of Sisters</strong></label>
                                    <input type="number" id="editSisters" name="editSisters" class="input-control"
                                        min="0" />
                                </div>
                                <!-- order of birth, are you the first child -->
                                <div class="info-group">
                                    <label for="editOrderOfBirth"><strong>Order of Birth</strong></label>
                                    <select name="editOrderOfBirth" id="editOrderOfBirth" class="input-control">
                                        <option value="First Born (Oldest)">First Born (Oldest)</option>
                                        <option value="Middle Child">Middle Child</option>
                                        <option value="Youngest">Youngest</option>
                                        <option value="Only Child">Only Child</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-section past-activities-container">
                        <h4 class="info-header">
                            <img class="btn-img" src="images/icons/certificate.png" alt="certificate" />
                            Resident Past Activities
                        </h4>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Certificate Type</th>
                                        <th>Purpose</th>
                                        <th>Date Issued</th>
                                        <th>Issued By</th>
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                <tbody id="certificates-table-body">
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No certificate history available.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="edit-resident-modal-actions">
                    <button class="btn close-edit-btn" type="button" onclick="closeEditModal()">Close</button>
                    <button class="btn save-edit-btn">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Resident Modal -->
    <div id="delete-resident-modal">
        <div class="delete-resident-modal-content">
            <h1>Delete this Resident</h1>
            <p>Are you sure you want to delete this resident?</p>
            <form action="../backend/fd_controllers/delete.controller.php" method="POST">
                <p>
                    Delete resident with ID:
                    <input type="text" id="resident-id-display-delete" name="resident_id"
                        class="resident-id-display-input" readonly>
                    <span>resident name</span>
                </p>
                <div class="delete-modal-actions">
                    <button class="action-button delete" type="submit" name="delete"> Yes, Delete</button>
                    <button class="action-button close-edit-btn" type="button" onclick="closeEditModal()">Close</button>
                </div>
            </form>
        </div>
    </div>
    <!-- MODALS END -->

    <script src="js/navigations.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/logout.modal.logic.js"></script>
    <script src="js/notifications.js"></script>
</body>

</html>