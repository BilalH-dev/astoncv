<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

// Redirect to CV page if user is already logged in
if (isset($_SESSION['userid'])) {
    header("Location: mycv.php");
    exit();
} 

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION["csrf-token"])) {
    $_SESSION["csrf-token"] = getRandomString(10);
}

$errors = [];
$email = $password = "";

// Login form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf-token"]) || $_POST["csrf-token"] != $_SESSION["csrf-token"]) {
        $errors["misc"] = "An unexpected error occurred. Please try again.";
        http_response_code(403);
        exit();
    }
        if (empty($_POST["email"])) {
        $errors["email"] = "Email address is required";
    } else {
        $email = validateData($_POST["email"]);
    }

     if (empty($_POST["password"])) {
        $errors["password"] = "Password is required";
    } else {
        $password = validateData($_POST["password"]);
    }

    // Look up the user in the database once all input validation is complete
    if ($errors == []) {
        $sql = "SELECT id, password FROM cvs WHERE email = ?";
        $login = $db->prepare($sql);
        $login->execute([$email]);

        // Check if user exists and verify password
        $user = $login -> fetch(PDO::FETCH_ASSOC);
        if ($user === false) {
            $errors["invaliduser"] = "Your email address or password is incorrect";
        } else {
            if (password_verify($password, $user["password"])) {
                $_SESSION["userid"] = $user["id"];
                header("Location: mycv.php");
                exit();
            } else {
                $errors["invalidpassword"] = "Your email address or password is incorrect";
            }
        } 
    }
    
} ?>

<!DOCTYPE html>
<head>
    <html lang="en-gb">
    <title>AstonCV | Login</title>
    <link rel="stylesheet" type="text/css" href="assets/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
</head>
<body>
    <header>
    <?php
    include 'includes/header-guest.php';
    ?>
    </header>
    <section class="main">
        <h1>Login</h1>
        <p>Log in to your account to view and edit your CV.</p>
        <p><em>Don't have an account?</em> <a href="register.php"><b>Register here</b></a>.</p>
        <?php
        // Display errors if there are any
        if (!empty($errors)) {
            echo "<section id='error-section'>";
            echo "<p class='error-title'>Your login attempt was unsuccessful:</p>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>";
                }
            echo "</ul>";
            echo "</section>";
        }
        ?>
        <form action="login.php" method="post"> 
            <label for="email">Email Address:</label> 
            <input type="email" size="50" id="email" name="email" placeholder="joebloggs12@example.com" title="Enter your email address" required><br><br>
            <label for="password">Password:</label> 
            <input type="password" size="54" id="password" name="password" placeholder="Enter your password" title="Enter your password" required><br><br> 
            <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?? '' ?>">
            <input type="submit" class="button"value="Log In"> 
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>