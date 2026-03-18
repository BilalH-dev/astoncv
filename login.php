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
    <title>AstonCV | Login</title>
</head>
<body>
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
</body>
</html>