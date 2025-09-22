<?php
session_start();
session_unset();
session_destroy();
header("Location: login?status=logged_out");
exit();