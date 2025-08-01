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
        case 'lupon':
            header("Location: /newkalalake.lgu.local/app/app.php?status=success");
            break;
        case 'admin':
            header("Location: /newkalalake.lgu.local/frontdesk/fd_app.php?status=success");
            break;
        default:
            header('Location: ../index.php');
    }
    exit();
}
