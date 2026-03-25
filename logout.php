<?php
require 'includes/db.php';
require 'includes/header-guest.php';
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
} else {
    session_unset();
    session_destroy();
    header("refresh:3; url=index.php");
} ?>

<!DOCTYPE html>
<html>
    <head>
        <html lang="en-gb">
        <title>AstonCV | Logout</title>
        <link rel="stylesheet" type="text/css" href="assets/styles.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body>
        <h1>Logout</h1>
        <p>You have been logged out successfully.</p>
        <p>Redirecting you to the <a href="index.php">home page</a>...</p>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>