<?php
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'dashboard';

$allowed_pages = [
    'dashboard',
    'resident',
    'certificates',
];

if (in_array($page, $allowed_pages)) {
    $content_file = '../../frontdesk/'. $page . '.php';

    if (file_exists($content_file)) {
        include $content_file;
    } else {
        echo '<h2 class="error-heading">Content Not Found</h2>';
        echo '<p class="error-message">The requested page content could not be found on the server.</p>';
    }
} else {
    echo '<h2 class="error-heading">Invalid Page Request</h2>';
    echo '<p class="error-message">The page you requested is not allowed or does not exist.</p>';
}

exit();