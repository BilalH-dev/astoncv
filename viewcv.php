<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();
?>

<!DOCTYPE html>
<head>
    <html lang="en-gb">
    <title>AstonCV | View CV Details</title>
    <link rel="stylesheet" type="text/css" href="assets/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <?php
        if (isset($_SESSION['userid'])) {
            include 'includes/header-user.php';
        } else {
            include 'includes/header-guest.php';
        } ?>
    </header>
    <section class="main">
    <h1>View CV Details</h1>
    <?php
    // Validate CV ID, display error if CV ID is not provided or invalid
    if (!isset($_GET['id'])) {
        echo("<p>No CV specified<br>Please go back to the CV list and try again.<br><br></p>");
        echo ('<a id="back-to-list" href="index.php">Back to CV List</a>');
        http_response_code(400);
        exit();
        }
    
    elseif (!is_numeric($_GET['id'])) {
        echo("<p>No CV specified<br>Please go back to the CV list and try again.<br><br></p>");
        echo ('<a id="back-to-list" href="index.php">Back to CV List</a>');
         http_response_code(400);
         exit();
    }
    else {
        // Retrieve CV information from database
        $cvId = $_GET['id']; 
    }

    $sql = "SELECT name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $result = $db->prepare($sql);
    $result->execute([$cvId]);
    // If CV ID is valid but CV is not found, display error message
    if (!$cv = $result->fetch()) {
            echo("<p>CV not found</p><br>");
            echo ('<a id="back-to-list" href="index.php">Back to CV List</a>');
            http_response_code(404);
            exit();
        } ?>
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
        <button type="button" onclick="window.location.href='index.php'">Back to CV List</button>
    </section>
</body>
</html>