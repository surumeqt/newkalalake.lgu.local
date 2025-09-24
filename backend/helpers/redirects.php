<?php
function redirect($target) {
    switch ($target) {
        case 'lupon':
            header("Location: lupon/dashboard");
            break;

        case 'office':
            header("Location: office/dashboard");
            break;

        case 'admin':
            header("Location: admin/dashboard");
            break;

        default:
            header("Location: /logout");
            break;
    }
    exit;
}