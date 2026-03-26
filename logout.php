<?php
require 'includes/db.php';
session_start();

// Check whether user is logged in, redirect to login page if not
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
} else {
    // Log out the user by clearing the session and redirecting to home page
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
         <!-- Favicon links - Logo from Aston University (aston.ac.uk) -->
          <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
          <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
          <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
          <link rel="manifest" href="favicons/site.webmanifest">
    </head>
    <body>
        <header>
        <?php
        include 'includes/header-guest.php';
        ?>
        <h1>Logout</h1>
        <p>You have been logged out successfully.</p>
        <p>Redirecting you to the <a href="index.php">home page</a>...</p>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>