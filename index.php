<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();
?>

<!DOCTYPE html>
<head>
    <html lang="en-gb">
    <title>AstonCV | Home</title>
    <link rel="stylesheet" type="text/css" href="assets/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <header>
        <?php
        // Show header based on user login status
        if (isset($_SESSION['userid'])) {
            include 'includes/header-user.php';
        } else {
            include 'includes/header-guest.php';
        } ?>
    </header>
    <section class="main">
        <h1>CV List</h1>
        <form action="index.php" method="GET" id="search-form">
        <input type="text" name="query" placeholder="Search CVs...">
        <button type="submit">Search</button>
        </form>
        <br>
        <?php
        // Display CVs based on search query
        if (isset($_GET['query'])) {
            $query = trim($_GET['query']);
            if (!empty($query)) {
                $query = '%' . $query . '%';
                $sql = "SELECT id, name, email, keyprogramming FROM cvs WHERE name LIKE ? OR keyprogramming LIKE ?";
                $result = $db -> prepare($sql);
                $result -> execute([$query, $query]);
            // Display all CVs if search query is empty
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
        // Display message if no CVs are found
        else {
            echo "No records found.";
        }
        ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>