<?php
function redirectIfNotLoggedIn() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../index.php?Invalid+Access');
        exit();
    }
}
function redirectBasedOnRole($role) {
    switch ($role) {
        case 'admin':
            header('Location: ../../app/app.php');
            break;
        case 'frontdesk':
            header('Location: ../../app/frontdesk/fd_app.php');
            break;
        default:
            header('Location: ./index.php');
    }
    exit();
}
