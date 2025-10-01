<?php include '../backend/helpers/redirects.php'; 
// redirectIfNotLoggedIn(['admin']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/fonts.css">
    <link rel="stylesheet" href="../public/css/root.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>office client</title>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Office System</h2>
            <button id="menu-toggle" onclick="toggleSidebar()">
                <img src="../public/assets/icons/menu-burger.png" alt="menu">
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <button onclick="loadContent('dashboard.php')">
                        <img src="../public/assets/icons/dashboard-panel.png">
                        <span>Dashboard</span>
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('residents.php')">
                        <img src="../public/assets/icons/user.png">
                        <span>Encode Residents</span>
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('certificates.php')">
                        <img src="../public/assets/icons/degree-credential.png">
                        <span>Issue Certificate</span>
                    </button>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button class="logout-button" onclick="showLogoutModal()">
                <img src="../public/assets/icons/user-logout.png">
                <span>Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main id="main-content">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../public/js/graph.js"></script>
</body>
</html>