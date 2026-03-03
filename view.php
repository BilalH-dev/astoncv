<?php
require 'includes/db.php';

function escapedString($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstonCV - View CV</title>
</head>
<body>
    <h1>View CV</h1>
    <?php
    if (!isset($_GET['id'])) {
        echo("<p>No CV specified<br>Please go back to the CV list and try again.<br><br></p>");
        echo ('<a href="index.php">Back to CV List</a>');
        http_response_code(400);
        exit();
        }
    
    elseif (!is_numeric($_GET['id'])) {
        echo("<p>No CV specified<br>Please go back to the CV list and try again.<br><br></p>");
        echo ('<a href="index.php">Back to CV List</a>');
         http_response_code(400);
         exit();
    }
    else {
        $cvId = $_GET['id']; 
    }

    $sql = "SELECT name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $result = $db->prepare($sql);
    $result->execute([$cvId]);
    if ($cv = $result->fetch()) {
        echo "<p><b>Name: </b>" . (escapedString($cv['name']) . "</p>");
        echo "<p><b>Email: </b>" . (escapedString($cv['email']) . "</p>");
        echo "<p><b>Key Programming Language: </b>" . (escapedString($cv['keyprogramming']) . "</p>");
        echo "<p><b>Profile: </b>" . (escapedString($cv['profile']) . "</p>");
        echo "<p><b>Education: </b>" . (escapedString($cv['education']) . "</p>");
        echo "<p><b>URL Link: </b>" . (escapedString($cv['URLlinks']) . "</p>");
        }
    
    else {
        echo("<p>CV not found</p><br>");
        http_response_code(404);
    }
    ?>
    <a href="index.php">Back to CV List</a>
</body>
</html>