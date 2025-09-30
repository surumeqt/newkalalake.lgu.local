<?php
require_once __DIR__ .'/../backend/bootstrap.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

switch ($uri) {
    case '':
    case 'login':
        (new backend\controllers\authcontroller())->login();
        break;

    case 'logout':
        (new backend\controllers\authcontroller())->logout();
        break;

    case 'submit-new-case':
        (new backend\controllers\casecontroller())->submitNewCase();
        break;
        
    case 'open-pdf':
        (new backend\controllers\casecontroller())->getPdf();
        break;

    case 'update-status':
        (new backend\controllers\casecontroller())->updateStatus();
        break;

    case 'add-summary':
        break;

    case 'delete-case':
        (new backend\controllers\casecontroller())->deleteCase();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}
