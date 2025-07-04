<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../backend/helpers/redirects.php'; redirectIfNotLoggedIn(); $user_email = $_SESSION['username'];?>
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
                    <li><a href="./database-page.php" data-load-content="true">Database</a></li>
                    <li class="nav-card-wrapper">
                        <span class="card-title">Lupon</span>
                        <ul>
                            <li><a href="./case-entry.php" data-load-content="true">Case Entry</a></li>
                            <li><a href="./cases.php" data-load-content="true">Pending Cases</a></li>
                            <li><a href="./rehearing.php" data-load-content="true">Re-hearing</a></li>
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

    <div id="status-modal" class="modal-overlay-status">
        <div class="modal-content-status">
            <h3>Change Case Status</h3>
            <form id="status-form" action="../backend/update.status.controller.php" method="post">
                <input type="hidden" name="Docket_Case_Number" id="modal-docket-status">
                <div class="modal-actions-status">
                    <button type="submit" name="Hearing_Status" value="Rehearing">Rehearing</button>
                    <button type="submit" name="Hearing_Status" value="Dismissed">Dismissed</button>
                    <button type="submit" name="Hearing_Status" value="Withdrawn">Withdrawn</button>
                    <button type="submit" name="Hearing_Status" value="Settled">Settled</button>
                    <button type="submit" name="Hearing_Status" value="CFA">CFA</button>
                </div>
            </form>
        </div>
    </div>

    <div id="rehearing-modal" class="modal-overlay-rehearing">
        <div class="modal-content-rehearing">
            <h3>Change Case Status</h3>
            <form id="rehearing-form" action="../backend/update.status.controller.php" method="post">
                <input type="hidden" name="Docket_Case_Number" id="modal-docket-rehearing">
                <div class="modal-actions-rehearing">
                    <button type="submit" name="Hearing_Status" value="Ongoing">Ongoing</button>
                    <button type="submit" name="Hearing_Status" value="Dismissed">Dismissed</button>
                    <button type="submit" name="Hearing_Status" value="Withdrawn">Withdrawn</button>
                    <button type="submit" name="Hearing_Status" value="Settled">Settled</button>
                    <button type="submit" name="Hearing_Status" value="CFA">CFA</button>
                </div>
            </form>
        </div>
    </div>

    <div id="summary-modal" class="modal-overlay-summary">
        <div class="modal-content-summary">
            <h3>Enter Report Summary</h3>
            <form id="summary-form" action="../backend/get.report.summary.php" method="post">
                <input type="hidden" name="Docket_Case_Number" id="modal-docket-summary">

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
                    <select id="action-selection" required>
                        <option value=""> --Choose Option--</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Dismissed">Dismissed</option>
                        <option value="Withdrawn">Withdrawn</option>
                        <option value="Settled">Settled</option>
                        <option value="CFA">CFA</option>
                    </select>
                    <button type="submit" class="submit-summary-btn">Save Summary</button>
                    <button type="button" class="cancel-summary-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODALS END -->
    <script src="js/navigations.js"></script>
    <script src="js/modal.logic.js"></script>
    <script src="js/modal.logic-summary.js"></script>
</body>
</html>