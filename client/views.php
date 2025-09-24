<?php
session_start();

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Split the URI into parts, "lupon/new-cases" → ["lupon", "new-cases"]
$parts = explode('/', $uri);

// Role folder lupon | office
$role = $parts[0] ?? null;

// Specific page dashboard, new-cases
$page = $parts[1] ?? 'dashboard';

// Prevent direct access to "main"
if ($page === 'main') {
    $page = 'dashboard'; // or just 404
}

// Base directory
$baseDir = __DIR__ . "/{$role}";

// Only allow lupon and office
if (in_array($role, ['lupon', 'office', 'admin'])) {

    // --- Auth Guard ---
    // if (!isset($_SESSION['user']) || $_SESSION['role'] !== $role) {
    //     header("Location: /logout");
    //     exit;
    // }

    $pageFile = "{$baseDir}/{$page}.php";
    $template = "{$baseDir}/main.php";

    if (file_exists($pageFile) && file_exists($template)) {
        // Make the page file available inside main.php
        $pageToLoad = $pageFile;
        require $template;
        exit;
    }
}

// Default fallback
http_response_code(404);
echo "Page not found.";
