<?php
session_start();
require("includes/db.php");

$errors = [];
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (empty($emailError) && empty($passwordError)) {
        $sql = "SELECT password FROM cvs WHERE email = ?";
        $login = $db->prepare($sql);
        $login->execute([$email]);

        $user = $login -> fetch(PDO::FETCH_ASSOC);
        if ($user === false) {
            $errors["invaliduser"] = "Your email address or password is incorrect";
            echo $errors["invaliduser"];
        } else {
            if (password_verify($password, $user["password"])) {
                $getUserIdSql = "SELECT id FROM cvs WHERE email = ?";
                $getUserId = $db->prepare($getUserIdSql);
                $getUserId->execute([$email]);
                $userId = $getUserId->fetchColumn();
                $_SESSION["userid"] = $userId;
                header("Location: mycv.php");
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

<h1>AstonCV Login</h1>
<a href="register.php">Register here if you do not have an account</a>
<br><br>
<form action="login.php" method="post"> 
    <label for="email">Email Address:</label> 
    <input type="text" id="email" name="email"><br><br>
    <label for="password">Password:</label> 
    <input type="password" id="password" name="password"><br><br> 
    <input type="submit" value="Log In"> 
</form>