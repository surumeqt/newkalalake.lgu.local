<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lupon client</title>
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
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
        </nav>
        <div class="sidebar-footer">
            <button class="logout-button">
                <img src="../public/assets/icons/user-logout.png"> Logout
            </button>
            <p>© 2025 Innovades BMS v1.0.3</p>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main id="main-content" class="content-card">
        <!-- Dynamic content will be loaded here -->
    </main>

    <script src="../public/js/loadContent.js"></script>
    <script> window.onload = () => { loadContent('dashboard.php'); } </script>
</body>
</html>