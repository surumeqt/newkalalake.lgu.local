<?php
/**
 * Bootstrap file
 * Loads environment variables, database, helpers, and autoloader.
 */

// Enable strict error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load environment variables (.env) if available
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // skip comments
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
        putenv(trim($name) . '=' . trim($value));
    }
}

require_once __DIR__ . '/../client/views.php';

// Database connection
require_once __DIR__ . '/config/database.config.php';

// Load helpers
foreach (glob(__DIR__ . '/helpers/*.php') as $helper) {
    require_once $helper; 
}

// autoloader for backend namespace Controllers, Models
spl_autoload_register(function ($class) {
    $prefix = 'backend\\';
    $base_dir = __DIR__ . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; 
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});