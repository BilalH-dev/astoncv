<?php
require 'includes/db.php';
session_start();
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $sql = "SELECT id, name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $getCv = $db->prepare($sql);
    $getCv->execute([$userid]);
    $cv = $getCv->fetch();
}
else {
    header("Location: login.php");
    exit();
}

function escapedString($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <html lang="en-gb">
        <title>AstonCV | My CV</title>
        <link rel="stylesheet" type="text/css" href="assets/styles.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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