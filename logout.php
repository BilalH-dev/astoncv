<?php
session_start();
require("includes/db.php"); ?>

<!DOCTYPE html>
<html>
<body>
    <h1>AstonCV</h1>
    <p>You have been logged out successfully.</p>

<?php
session_unset();
session_destroy();
?>

</body>
</html>