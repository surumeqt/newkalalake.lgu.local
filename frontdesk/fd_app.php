<?php
// file: frontdesk/fd_app.php   
include '../backend/config/database.config.php';
include '../backend/helpers/redirects.php';
redirectIfNotLoggedIn();
$user_email = $_SESSION['username'];
$current_page = basename($_SERVER['PHP_SELF']);
$pdo = (new Connection())->connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU - Brgy. New Kalalake System</title>
    <link rel="icon" type="image/png" href="images/logos/barangay_logo.png">
    <link rel="stylesheet" href="css/app.frontdesk.css">
    <link rel="stylesheet" href="css/modal.style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="dashboard-layout">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay">
        </div>
        <aside class="sidebar">
            <div class="logo-area">
                <img class="brgy_logo" src="images/logos/barangay_logo.png" alt="Logo">
                <h1>Brgy. New Kalalake</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="./fd_dashboard.php" data-load-content="true" data-url="fd_dashboard.php"
                            data-tab="dashboard">Dashboard</a></li>
                    <li><a href="./fd_residents.php" data-load-content="true" data-url="fd_residents.php">Residents</a>
                    </li>
                    <li class="fdresidentprofile_li"><a class="fdresidentprofile_a" href="./fd_resident_profile.php"
                            data-load-content="true" data-url="fd_resident_profile.php">Resident
                            Profile</a>
                    </li>
                    <li><a href="./fd_certificate.php" data-load-content="true">Certificate</a></li>
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

            <!-- dynamically loading content from fd_dashboard.php, fd_residents.php, fd_certificate.php -->
            <div class="content-display">

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

    <!-- MODALS END -->

    <script src="js/navigations.js"></script>
    <script src="js/modal.logic.js"></script>
</body>

</html>