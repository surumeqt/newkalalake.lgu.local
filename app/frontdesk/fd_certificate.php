<?php
// file: app/frontdesk/fd_certificate.php
include '../../backend/config/database.config.php';
include '../../backend/helpers/redirects.php';
redirectIfNotLoggedIn();
$user_email = $_SESSION['username'];
$current_page = basename($_SERVER['PHP_SELF']);
$pdo = (new Connection())->connect();
?>

<h2>Certificate Management</h2>
<p>Certificate functionality coming soon...</p>

<!-- MODALS START -->

<!-- MODALS END -->

<script src="../js/navigations.js"></script>
<script src="../js/modal.logic.js"></script>
<script src="../js/dashboard.logic.js"></script>
<script src="../js/responsive-sidebar.js"></script>