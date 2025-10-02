<?php require_once '../backend/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../public/assets/icons/logo.png">
    <link rel="stylesheet" href="../public/css/fonts.css">
    <link rel="stylesheet" href="../public/css/root.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="css/lupon.pages.css">
    <title>lupon client</title>
</head>
<body>
     <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Lupon System</h2>
            <button id="menu-toggle" onclick="toggleSidebar()">
                <img src="../public/assets/icons/menu-burger.png" alt="menu">
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <button onclick="loadContent('dashboard.php')">
                        <img src="../public/assets/icons/dashboard-panel.png" alt="dashboard">
                        <span>Dashboard</span>
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('database.php')">
                        <img src="../public/assets/icons/database.png" alt="database">
                        <span>Database</span>
                    </button>
                </li>
                <hr>
                <li>
                    <button onclick="loadContent('case-entry.php')">
                        <img src="../public/assets/icons/legal-case.png" alt="case">
                        <span>New Cases</span>
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('case-pending.php')">
                        <img src="../public/assets/icons/pending.png" alt="pending">
                        <span>Pending Cases</span>
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('case-rehearing.php')">
                        <img src="../public/assets/icons/calendar-clock.png" alt="rehearing">
                        <span>Rehearing Cases</span>
                    </button>
                </li>
                <hr>
                <li>
                    <button onclick="loadContent('case-upload.php')">
                        <img src="../public/assets/icons/document-circle-arrow-up.png" alt="upload">
                        <span>Upload Cases</span>
                    </button>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button onclick="showLogoutModal()">
                <img src="../public/assets/icons/user-logout.png" alt="logout">
                <span>Logout</span>
            </button>
        </div>
    </aside>
    
    <main id="main-content">
        </main>

    <!-- Logout Modal -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Confirm Logout</h3>
            <p>Are you sure you want to log out?</p>
            <div class="modal-actions">
                <button id="confirmLogout" class="btn btn-confirm" onclick="window.location.href = '../public/logout.php'">Yes, Logout</button>
                <button id="cancelLogout" class="btn btn-cancel" onclick="hideLogoutModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../public/js/loadContent.js"></script>
    <script> window.onload = () => { loadContent('dashboard.php'); } </script>
</body>
</html>