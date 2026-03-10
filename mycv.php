<?php
session_start();
require("includes/db.php");

function escapedString($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['userid'])) {
    echo("You are not logged in.");
    exit();
}

else {
    $userid = $_SESSION['userid'];
    echo('<a href="index.php">Home</a> <a href="mycv.php">My CV</a> <a href="editcv.php">Edit CV</a> <a href="logout.php">Log Out</a>');
    echo('<h1>My CV</h1>You may find a full record of your CV below. <br> If anything is incorrect, you can edit it <a href="editcv.php">here</a>.');
    $sql = "SELECT id, name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $getCv = $db->prepare($sql);
    $getCv->execute([$userid]);
    $cv = $getCv->fetch();
    echo "<p><b>ID: </b>" . (escapedString($cv['id']) . "</p>");
    echo "<p><b>Name: </b>" . (escapedString($cv['name']) . "</p>");
    echo "<p><b>Email: </b>" . (escapedString($cv['email']) . "</p>");
    echo "<p><b>Key Programming Language: </b>" . (escapedString($cv['keyprogramming']) . "</p>");
    echo "<p><b>Profile: </b>" . (escapedString($cv['profile']) . "</p>");
    echo "<p><b>Education: </b>" . (escapedString($cv['education']) . "</p>");
    echo "<p><b>URL Link: </b>" . (escapedString($cv['URLlinks']) . "</p>");
}
?>