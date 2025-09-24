<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/fonts.css">
    <link rel="stylesheet" href="../../public/css/root.css">
    <link rel="stylesheet" href="../../public/css/adminpages.css">
    <title>Admin System</title>
</head>
<body>
    <nav>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/post">Create Post</a>
        <a href="/admin/blogs">Create Blogs</a>
        <a href="/admin/users">Manage Users</a>
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
