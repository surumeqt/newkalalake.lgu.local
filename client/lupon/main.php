<!DOCTYPE html>
<html>
<head>
    <title>Lupon System</title>
</head>
<body>
    <nav>
        <!-- Your Lupon navigation bar -->
        <a href="/lupon/dashboard">Dashboard</a>
        <a href="/lupon/database">Database</a>
        <a href="/lupon/new-cases">New Cases</a>
        <a href="/lupon/pending-cases">Pending Cases</a>
        <a href="/lupon/rehearing-cases">Rehearing Cases</a>
        <a href="/lupon/upload-cases">Upload Cases</a>
    </nav>

    <main>
        <?php 
            // Load the requested page inside the template
            if (isset($pageToLoad)) {
                require $pageToLoad;
            }
        ?>
    </main>
</body>
</html>
