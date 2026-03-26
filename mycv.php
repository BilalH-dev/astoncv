<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

// Check if user is logged in and retrieve CV information
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $sql = "SELECT id, name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $getCv = $db->prepare($sql);
    $getCv->execute([$userid]);
    $cv = $getCv->fetch();
}
else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
} ?>

<!DOCTYPE html>
<html>
    <head>
        <html lang="en-gb">
        <title>AstonCV | My CV</title>
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
    <header>
        <?php
        include 'includes/header-user.php';
        ?>
    </header>
    <body>
        <section class="main">
        <h1>My CV</h1>
        <p>You can view your CV details below. If you wish to edit your CV, please go to the <a href="editcv.php"><b>Edit CV</b></a> page.</p>
        <table>
        <tr>
            <th>Name</th>
            <td><?php echo escapedString($cv['name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo escapedString($cv['email']); ?></td>
        </tr>
        <tr>
            <th>Key Programming Language</th>  
            <td><?php echo escapedString($cv['keyprogramming']); ?></td>
        </tr>
            <tr>
                <th>Profile</th>  
                <td><?php echo escapedString($cv['profile']); ?></td>
            </tr>
            <tr>
                <th>Education</th>  
                <td><?php echo escapedString($cv['education']); ?></td>
            </tr>
            <tr>
                <th>URL Links</th>  
                <td><?php echo escapedString($cv['URLlinks']); ?></td>
            </tr>
        </table>
        <br>
    </section>
</body>
</html>