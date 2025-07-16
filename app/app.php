<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../backend/helpers/redirects.php'; 
    redirectIfNotLoggedIn(); 
    $user_email = $_SESSION['username'];
    $showSuccess = isset($_GET['status']) && $_GET['status'] === 'success';
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU - Brgy. New Kalalake System</title>
    <link rel="stylesheet" href="css/app.admin.css">
    <link rel="stylesheet" href="css/modal.style.css">
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo-area">
                <img class="brgy_logo" src="../app/images/logo.png" alt="Logo">
                <h1>Brgy. New Kalalake</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="./dashboard.php" data-load-content="true">Dashboard</a></li>
                    <li><a href="./database-page.php" data-load-content="true">Database Records</a></li>
                    <li class="nav-card-wrapper">
                        <span class="card-title">Lupon</span>
                        <ul>
                            <li><a href="./case-entry.php" data-load-content="true">Case Entry</a></li>
                            <li><a href="./cases.php" data-load-content="true">Pending Cases</a></li>
                            <li><a href="./rehearing.php" data-load-content="true">Rehearing Cases</a></li>
                        </ul>
                    </li>
                    <li><a href="./upload.php" data-load-content="true">Upload</a></li>
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
    <?php if ($showSuccess): ?>
        <div id="success-toast" class="success-toast">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" class="checkmark">
                    <path d="M5 13l4 4L19 7" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="success-message">Case successfully submitted!</div>
        </div>
    <?php endif; ?>

    <!-- Logout Modal -->
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

    <!-- Status Modal -->
    <div id="status-modal" class="modal-overlay-status">
        <div class="modal-content-status">
            <h3>Change Case Status</h3>
            <form id="status-form" action="../backend/update.status.controller.php" method="post">
                <input type="hidden" name="Docket_Case_Number" id="modal-docket-status">
                <input type="hidden" name="Hearing_Status" id="status-selected-value">

                <div class="form-group-status-select"> <label for="status-selection" class="summary-label">Select New Status:</label>
                    <select id="status-selection" class="summary-select" required>
                        <option value="">-- Choose Status --</option>
                        <option name="Hearing_Status" value="Rehearing">Rehearing</option>
                        <option name="Hearing_Status" value="Dismissed">Dismissed</option>
                        <option name="Hearing_Status" value="Withdrawn">Withdrawn</option>
                        <option name="Hearing_Status" value="Settled">Settled</option>
                        <option name="Hearing_Status" value="CFA">CFA</option>
                    </select>
                </div>

                <div class="form-group-summary" id="status-report-summary-group" style="display: none;">
                    <label for="status_report_summary_text" class="summary-label">Report Summary:</label>
                    <textarea
                        id="status_report_summary_text"
                        name="report_summary_text"
                        rows="5"
                        placeholder="Enter summary details here..."
                        class="summary-textarea"></textarea>
                </div>

                <div class="modal-actions-status">
                    <button type="submit" class="submit-status-btn">Update Status</button>
                    <button type="button" class="cancel-status-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    

    <!-- Summary Modal -->
    <div id="summary-modal" class="modal-overlay-summary">
        <div class="modal-content-summary">
            <h3>Enter Report Summary & Change Status</h3>
            <form id="summary-form" action="../backend/summary.controller.php" method="POST">
                <input type="hidden" name="Docket_Case_Number" id="modal-docket-summary">
                <input type="hidden" name="Hearing_Status" id="modal-selected-status-for-submit">

                <div class="form-group-summary">
                    <label for="report_summary_text" class="summary-label">Summary Details</label>
                    <textarea
                        id="report_summary_text"
                        name="report_summary_text"
                        rows="8"
                        placeholder="Type the report summary here..."
                        required
                        class="summary-textarea"></textarea>
                </div>

                <div class="modal-actions-summary">
                    <div class="action-group">
                        <div class="form-group-select">
                            <label for="action-selection" class="summary-label">Change Status To:</label>
                            <select id="action-selection" class="summary-select" required>
                                <option value="">-- Choose Option --</option>
                                <option name="Hearing_Status" value="Ongoing">Ongoing</option>
                                </select>
                        </div>
                        <div class="form-group-date" id="next-hearing-date-group">
                            <label for="next_hearing_date" class="summary-label">Next Hearing Date</label>
                            <input type="date" id="next_hearing_date" name="Hearing_Date" class="summary-input" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time of Hearing (ex. 10:00 AM)</label>
                            <div class="form-relative">
                                <input type="text" placeholder="Enter Time of Hearing" id="hours" name="hours" required class="form-input">
                                <select id="iat" name="iat" required class="form-relative-select">
                                    <option value="">-- Select Time Class --</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="submit-summary-btn">Save & Update</button>
                        <button type="button" class="cancel-summary-btn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- GALLERY MODAL -->
    <div id="gallery-modal" class="modal-overlay-gallery">
        <div class="modal-content-gallery">
            <h3>Uploaded Files</h3>
            <div class="gallery-images"></div>
            <div class="modal-actions">
                <button onclick="closeGalleryModal()" class="btn btn-cancel">Close</button>
            </div>
        </div>
    </div>

    <!-- MODALS END -->
    <script src="js/navigations.js"></script>
    <script src="js/database.page.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/modal.logic.js"></script>
    <script src="js/modal.logic-summary.js"></script>
</body>
</html>