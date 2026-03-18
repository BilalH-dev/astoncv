<?php
require 'includes/db.php';
require 'includes/header-guest.php';
session_start();
if (isset($_SESSION['userid'])) {
    session_unset();
    session_destroy();
} else {
    header("Location: login.php");
    exit();
}?>

<!DOCTYPE html>
<html>
    <head>
        <title>AstonCV | Logout</title>
    </head>
<body>
    <p>You have been logged out successfully.</p>
</body>
</html>