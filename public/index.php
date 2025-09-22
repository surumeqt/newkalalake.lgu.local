<?php
require_once __DIR__ . '/../backend/bootstrap.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

switch ($uri) {
    case '':
    case 'login':
        (new backend\controllers\authcontroller())->login();
        break;

    case 'logout':
        (new backend\controllers\authcontroller())->logout();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}
