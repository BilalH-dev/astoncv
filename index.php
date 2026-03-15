<?php
require 'includes/db.php';
session_start();
if (isset($_SESSION['userid'])) {
    require 'includes/header-user.php';
} else {
    require 'includes/header-guest.php';
}

function escapedString($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<head>
    <title>AstonCV | Home</title>
</head>
<body>
    <form action="index.php" method="GET">
        <input type="text" name="query" placeholder="Search CVs...">
        <button type="submit">Search</button>
    </form>
    <section id="cv-list">
        <h2>CV List</h2>
        <?php
        if (isset($_GET['query'])) {
            $query = trim($_GET['query']);
            if (!empty($query)) {
                $query = '%' . $query . '%';
                $sql = "SELECT id, name, email, keyprogramming FROM cvs WHERE name LIKE ? OR keyprogramming LIKE ?";
                $result = $db -> prepare($sql);
                $result -> execute([$query, $query]);
            } else {
                $sql = "SELECT id, name, email, keyprogramming FROM cvs";
                $result = $db->query($sql);
            }
        } else {
                $sql = "SELECT id, name, email, keyprogramming FROM cvs";
                $result = $db->query($sql);
        }
            

        if ($result->rowCount() > 0) {
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Key Programming Language</th>
                    </tr>";
            while($row = $result->fetch()) {
                echo "<tr>";
                echo "<td><a href=viewcv.php?id=". escapedString($row['id']) . ">" . escapedString($row['name']) . "</a></td>";
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