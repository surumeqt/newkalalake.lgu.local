<?php include '../backend/helpers/redirects.php';
// redirectIfNotLoggedIn(['lupon']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lupon client</title>
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="css/lupon.pages.css">
</head>
<body>
    <button onclick="toggleSidebar()" class="sidebar-toggle">
        <img src="../public/assets/icons/menu-burger.png" width="30px" height="30px">
    </button>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>Lupon System</h1>
        </div>
        <nav>
            <ul>
                <li>
                    <button onclick="loadContent('dashboard.php')">
                        <img src="../public/assets/icons/dashboard-panel.png"> Dashboard
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('database.php')">
                        <img src="../public/assets/icons/database.png"> Database
                    </button>
                </li>
            </ul>
            <hr>
            <ul>
                <li>
                    <button onclick="loadContent('case-entry.php')">
                        <img src="../public/assets/icons/legal-case.png"> New Case
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('case-pending.php')">
                        <img src="../public/assets/icons/pending.png"> Pending Cases
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('case-rehearing.php')">
                        <img src="../public/assets/icons/calendar-clock.png"> Rehearing Cases
                    </button>
                </li>
            </ul>
            <hr>
            <ul>
                <li>
                    <button onclick="loadContent('case-upload.php')">
                        <img src="../public/assets/icons/document-circle-arrow-up.png"> Upload & Encode old Cases
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

    <main id="main-content" class="content-card">
        </main>

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