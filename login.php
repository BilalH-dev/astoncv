<?php
require 'includes/db.php';
session_start();
if (isset($_SESSION['userid'])) {
    header("Location: mycv.php");
    exit();
} else {
    require 'includes/header-guest.php';
}

function getRandomString($n) {
    return bin2hex(random_bytes($n / 2));
}

if (!isset($_SESSION["csrf-token"])) {
    $_SESSION["csrf-token"] = getRandomString(10);
}

$errors = [];
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf-token"]) || $_POST["csrf-token"] != $_SESSION["csrf-token"]) {
        $errors["misc"] = "An unexpected error occurred. Please try again.";
        http_response_code(403);
        echo $errors["misc"];
        exit();
    }
        if (empty($_POST["email"])) {
        $errors["email"] = "Email address is required";
        echo $errors["email"];
    } else {
        $email = validateData($_POST["email"]);
    }

     if (empty($_POST["password"])) {
        $errors["password"] = "Password is required";
        echo $errors["password"];
    } else {
        $password = validateData($_POST["password"]);
    }

    if ($errors == []) {
        $sql = "SELECT id, password FROM cvs WHERE email = ?";
        $login = $db->prepare($sql);
        $login->execute([$email]);

        $user = $login -> fetch(PDO::FETCH_ASSOC);
        if ($user === false) {
            $errors["invaliduser"] = "Your email address or password is incorrect";
            echo $errors["invaliduser"];
        } else {
            if (password_verify($password, $user["password"])) {
                $_SESSION["userid"] = $user["id"];
                header("Location: mycv.php");
                exit();
            } else {
                $errors["invalidpassword"] = "Your email address or password is incorrect";
                echo $errors["invalidpassword"];
            }
        } 
    }
    
}

function validateData($data) {
    $data = trim($data);
    return $data;
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
    <section class="main">
        <h1>Login</h1>
        <p>Log in to your account to view and edit your CV.</p>
        <p><em>Don't have an account?</em> <a href="register.php"><b>Register here</b></a>.</p>
        <br>
        <form action="login.php" method="post"> 
            <label for="email">Email Address:</label> 
            <input type="email" id="email" name="email"><br><br>
            <label for="password">Password:</label> 
            <input type="password" id="password" name="password"><br><br> 
            <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?? '' ?>">
            <input type="submit" value="Log In"> 
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>