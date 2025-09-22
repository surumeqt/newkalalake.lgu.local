<?php include '../backend/helpers/redirects.php'; 
// redirectIfNotLoggedIn(['admin']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../public/assets/icons/logo.png">
    <title>admin</title>
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <h1>Admin System</h1>
        </div>
        <nav>
            <ul>
                <li>
                    <button onclick="loadContent('dashboard.php')">
                        <img src="../public/assets/icons/dashboard-panel.png"> Dashboard
                    </button>
                </li>
            </ul>
            <hr>
            <ul>
                <li>
                    <button onclick="loadContent('residents.php')">
                        <img src="../public/assets/icons/user.png"> Encode Residents
                    </button>
                </li>
            </ul>
            <hr>
            <ul>
                <li>
                    <button onclick="loadContent('certificates.php')">
                        <img src="../public/assets/icons/degree-credential.png"> Issue Certificate
                    </button>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button class="logout-button" onclick="showLogoutModal()">
                <img src="../public/assets/icons/user-logout.png"> Logout
            </button>
            <p>© 2025 Innovades BMS v1.0.3</p>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main id="main-content" class="content-card">
        <!-- Dynamic content will be loaded here -->
    </main>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Confirm Logout</h3>
            <p>Are you sure you want to log out?</p>
            <div class="modal-actions">
                <button id="confirmLogout" class="btn btn-confirm">Yes, Logout</button>
                <button id="cancelLogout" class="btn btn-cancel" onclick="hideLogoutModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../public/js/loadContent.js"></script>
    <script> window.onload = () => { loadContent('dashboard.php'); } </script>
</body>
</html>