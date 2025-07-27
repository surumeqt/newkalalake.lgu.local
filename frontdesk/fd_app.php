<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../backend/helpers/redirects.php';
    redirectIfNotLoggedIn();
    $user_email = $_SESSION['username']; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU - Brgy. New Kalalake System</title>
    <link rel="stylesheet" href="css/app.frontdesk.css">
    <link rel="stylesheet" href="css/modal.style.css">
</head>

<body>
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
                    <li><a href="./fd_resident_profile.php" data-load-content="true">Resident Profile</a></li>
                    <li><a href="./fd_certificate.php" data-load-content="true">Certificate</a></li>
                    <li><a href="./fd_records.php" data-load-content="true">History Records</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <p class="user-email-display"><?php echo htmlspecialchars($user_email); ?></p>
                <button id="logoutButton" class="logout-btn">Logout</button>
            </div>
        </aside>

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
            <h1>Edit Resident</h1>
            <p>this is the resident profile, the user can edit or update specific resident information</p>
            <p>Editing resident with ID: <span id="resident-id-display"></span></p>
            <div class="edit-resident-modal-actions">
                <button>Save</button>
                <button onclick="closeEditModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Delete Resident Modal -->
    <div id="delete-resident-modal">
        <div class="delete-resident-modal-content">
            <h1>Delete this Resident</h1>
            <p>this is will delete the resident records in the database</p>
            <form action="../backend/fd_controllers/delete.controller.php" method="POST">
                <p>
                    Delete resident with ID:
                    <input type="text" id="resident-id-display-delete" name="resident_id" hidden>
                    <span>resident name</span>
                </p>
                <div class="delete-modal-actions">
                    <button type="submit" name="delete">Delete</button>
                    <button type="button" onclick="closeEditModal()">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODALS END -->

    <script src="js/navigations.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/logout.modal.logic.js"></script>
</body>

</html>