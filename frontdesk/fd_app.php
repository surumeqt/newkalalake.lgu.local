<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../backend/helpers/redirects.php'; redirectIfNotLoggedIn(); $user_email = $_SESSION['username'];?>
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
            <h1>Register New Residents</h1>
            <form id="addResidentForm" class="modal-form" action="../backend/fd_controllers/resident.controller.php"
                method="POST" enctype="multipart/form-data">
                <div class="modal-body">
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
                            <input type="text" id="suffix" name="suffix" class="form-control"
                                placeholder="e.g., Jr., Sr., III">
                        </div>
                    </div>
                    <div class="form-divider">
                        <div class="form-group">
                            <label for="birthDate">Date of Birth:</label>
                            <input type="date" id="birthDate" name="birthday" class="form-control" required onchange="reflectAge()">
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
                            <input type="text" id="contact_number" name="contact" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1rem; border-top: 1px solid #ccc; padding-top: 1rem;">
                        <label for="photo">Resident Photo (Optional):</label>
                        <input type="file" id="photo" name="file_upload[]" accept="image/*" class="form-control-file">
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