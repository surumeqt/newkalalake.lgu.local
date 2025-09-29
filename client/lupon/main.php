<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/fonts.css">
    <link rel="stylesheet" href="../../public/css/root.css">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/luponpages.css">
    <title>Lupon System</title>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Lupon System</h2>
            <button id="menu-toggle" onclick="toggleSidebar()">
                <img src="../../public/assets/icons/menu-burger.png" alt="menu">
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <img src="../../public/assets/icons/dashboard-panel.png" alt="dashboard">
                    <a href="/lupon/dashboard">Dashboard</a>
                </li>
                <li>
                    <img src="../../public/assets/icons/database.png" alt="database">
                    <a href="/lupon/database">Database</a>
                </li>
                <li>
                    <img src="../../public/assets/icons/legal-case.png" alt="case">
                    <a href="/lupon/new-cases">New Cases</a>
                </li>
                <li>
                    <img src="../../public/assets/icons/pending.png" alt="pending">
                    <a href="/lupon/pending-cases">Pending Cases</a>
                </li>
                <li>
                    <img src="../../public/assets/icons/calendar-clock.png" alt="rehearing">
                    <a href="/lupon/rehearing-cases">Rehearing Cases</a>
                </li>
                <li>
                    <img src="../../public/assets/icons/document-circle-arrow-up.png" alt="home">
                    <a href="/lupon/upload-cases">Upload Cases</a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button onclick="showLogoutModal()">
                <img src="../../public/assets/icons/user-logout.png" alt="logout">
                <span>Logout</span>
            </button>
        </div>
    </aside>
    
    <main class="main-content">
        <?php if (isset($pageToLoad)) { require $pageToLoad; } ?>
    </main>

    <!-- Logout Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to logout?</p>
            <div class="modal-actions">
                <button class="cancel-btn" onclick="showLogoutModal()">Cancel</button>
                <form action="/logout" method="POST" style="display:inline;">
                    <button class="confirm-btn" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <h2>Update Status</h2>
            <p>Are you sure you want to change the status for this case?</p>
            <p>it will be change to : Rehearing</p>
            <div class="modal-actions">
                <button class="cancel-btn" onclick="showUpdateModal()">Cancel</button>
                <form action="/update-status" method="POST" style="display:inline;">
                    <input hidden type="text" id="case-number-update" name="case_id">
                    <button class="confirm-btn" type="submit">Yes</button>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Delete Case</h2>
            <p>Are you sure you want to DELETE this case?</p>
            <div class="modal-actions">
                <button class="cancel-btn" onclick="showDeleteModal()">Cancel</button>
                <form action="/delete-case" method="POST" style="display:inline;">
                    <input hidden type="text" id="case-number-delete" name="case_id">
                    <button class="confirm-btn" type="submit">Yes</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../public/js/functions.js"></script>
</body>
</html>