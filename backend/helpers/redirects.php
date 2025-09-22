<?php
function redirectIfNotLoggedIn($allowedRoles = []) {
    session_start();

    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ../index?error=unauthorized');
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
                header('Location: ../public/logout');
                exit();
        }
    }
}

function redirectBasedOnRole($role, $message = '') {
    switch ($role) {
        case 'lupon':
            header("Location: ../lupon-client/main"."$message");
            break;
        case 'admin':
            header("Location: ../office-client/main"."$message");
            break;
        default:
            header('Location: ../index');
    }
    exit();
}