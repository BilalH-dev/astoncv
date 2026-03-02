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
    <title>AstonCV</title>
</head>
<body>
    <h1>AstonCV</h1>
    <section id="cv-list">
        <h2>CV List</h2>
        <?php
        $sql = "SELECT id, name, email, keyprogramming FROM cvs";
        $result = $db->query($sql);
        if ($result->rowCount() > 0) {
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Key Programming Language</th>
                    </tr>";
            while($row = $result->fetch()) {
                echo "<tr>";
                echo "<td><a href=view.php?id=". escapedString($row['id']) . ">" . escapedString($row['name']) . "</a></td>";
                echo "<td>" . escapedString($row['email']) . "</td>";
                echo "<td>" . escapedString($row['keyprogramming']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            unset($result);
        }
        else {
            echo "No records found.";
        }
        ?>
    </section>
</body>
</html>