<?php
function redirectIfNotLoggedIn($allowedRoles = []) {
    session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ../index.php?error=unauthorized');
        exit();
    }

    if (!in_array($_SESSION['role'], $allowedRoles)) {
        switch ($_SESSION['role']) {
            case 'lupon':
                redirectBasedOnRole('lupon', '?status=failed');
                break;
            case 'admin':
                redirectBasedOnRole('admin', '?status=failed');
                break;
            default:
                header('Location: ../../frontdesk/logout.php');
                exit();
        }
    }
}
function redirectBasedOnRole($role, $message = '') {
    switch ($role) {
        case 'lupon':
            header("Location: /newkalalake.lgu.local/lupon/app.php"."$message");
            break;
        case 'admin':
            header("Location: /newkalalake.lgu.local/frontdesk/app.php"."$message");
            break;
        default:
            header('Location: ../index.php');
    }
    exit();
}