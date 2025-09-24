<!DOCTYPE html>
<html>
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
    <header>
        <h1>Lupon System</h1>
        <nav>
            <a href="/lupon/dashboard">Dashboard</a>
            <a href="/lupon/database">Database</a>
            <a href="/lupon/new-cases">New Cases</a>
            <a href="/lupon/pending-cases">Pending Cases</a>
            <a href="/lupon/rehearing-cases">Rehearing Cases</a>
            <a href="/lupon/upload-cases">Upload Cases</a>
            <button class="logout-btn" onclick="showLogoutModal()">
                Logout
            </button>
        </nav>
    </header>

    <main>
        <?php
            // Load the requested page inside the template
            if (isset($pageToLoad)) {
                require $pageToLoad;
            }
        ?>
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

    <script src="../../public/js/functions.js"></script>
</body>
</html>
