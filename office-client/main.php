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
            <h1>Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li>
                    <button onclick="loadContent('dashboard.php')">
                        <span>🏠</span> Dashboard
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('residents.php')">
                        <span>🗃️</span> Residents
                    </button>
                </li>
                <li>
                    <button onclick="loadContent('certificates.php')">
                        <span>📄</span> Certificates
                    </button>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <p>© 2023 Dynamic Layout</p>
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