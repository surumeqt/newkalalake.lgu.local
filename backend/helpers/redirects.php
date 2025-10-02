<?php
function redirect($target) {
    switch ($target) {
        case 'lupon':
            header("Location: ../../lupon-client/main");
            break;

        case 'office':
            header("Location: ../../office-client/main");
            break;

        case 'admin':
            header("Location: ../../admin/main");
            break;

        default:
            header("Location: ../../public/logout");
            break;
    }
    exit;
}