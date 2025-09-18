<?php
function redirectBasedOnRole($role, $message = '') {
    switch ($role) {
        case 'lupon':
            header("Location: /newkalalake.lgu.local/lupon-client/main.php"."$message");
            break;
        case 'admin':
            header("Location: /newkalalake.lgu.local/office-client/main.php"."$message");
            break;
        default:
            header('Location: ../index.php');
    }
    exit();
}