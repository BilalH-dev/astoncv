<?php
session_start();
require 'includes/db.php';

function getRandomString($n) {
    return bin2hex(random_bytes($n / 2));
}

if (!isset($_SESSION["csrf-token"])) {
    $_SESSION["csrf-token"] = getRandomString(10);
}

$errors = [];
$name = $email = $password = $keyprogramming = $profile = $education = $URLlinks = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf-token"]) || $_POST["csrf-token"] != $_SESSION["csrf-token"]) {
        $errors["misc"] = "An unexpected error occurred. Please try again.";
        http_response_code(403);
        echo $errors["misc"];
        exit();
    }
    if (empty($_POST["name"])) {
        $errors["name"] = "Name is required<br>";
        echo $errors["name"];
    } else {
        $name = validateData($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $errors["name"] = "Name must only contain letters and whitespace<br>";
            echo $errors["name"];
    } }
    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required<br>";
        echo $errors["email"];
    }
        else {
        $email = validateData($_POST["email"]);
        // Check whether if email is already linked to an account
        $checkEmailsql = "SELECT email FROM cvs WHERE email = ?";
        $checkEmail = $db->prepare($checkEmailsql);
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() != 0) {
            $errors["email"] = "Email already exists<br>";
            echo $errors["email"];
            }
        }
    if (empty($_POST["password"])) {
        $errors["password"] = "Password is required<br>";
        echo $errors["password"];
    } else {
        $password = validateData($_POST["password"]);
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($_POST["keyprogramming"])) {
        $errors["keyprogramming"] = "Key programming language is required<br>";
        echo $errors["keyprogramming"];
    } else {
        $keyprogramming = validateData($_POST["keyprogramming"]);
    }
    if (!isset($_POST["profile"])) {
        $profile = "";
    }
    elseif ((strlen($_POST["profile"])) > 500) {
        $errors["profile"] = "Profile text must be less than 500 characters<br>";
        echo $errors["profile"];
    }
    else {
        $profile = validateData($_POST["profile"]);
    }
    if (!isset($_POST["education"])) {
        $education = "";
    }
    elseif ((strlen($_POST["education"])) > 500) {
        $errors["education"] = "Education text must be less than 500 characters<br>";
        echo $errors["education"];
    }
    else {
        $education = validateData($_POST["education"]);
    }
    if (!isset($_POST["links"])) {
        $URLlinks = "";
    }
    elseif ((strlen($_POST["links"])) > 500) {
        $errors["links"] = "Links field must be less than 500 characters<br>";
        echo $errors["links"];
    }
    else {
        $URLlinks = validateData($_POST["links"]);
    }

    if (empty($errors)) {
    $sql = "INSERT INTO cvs (name, email, password, keyprogramming, profile, education, URLlinks) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $register = $db -> prepare($sql);
    $register -> execute([$name, $email, $password, $keyprogramming, $profile, $education, $URLlinks]);
    $userId = $db->lastInsertId();
    $_SESSION["userid"] = $userId;
    header("Location: mycv.php");
    exit();
    }
}

function validateData($data) {
    $data = trim($data);
    return $data;
} ?>

<h1>Register</h1>
<form action="register.php" method="post"> 
    <label for="name">Name:</label> 
    <input type="text" id="name" name="name" placeholder="Joe Bloggs" required><br>
    <br>
    <label for="email">Email:</label> 
    <input type="email" id="email" name="email" placeholder="joebloggs12@example.com" required><br>
    <br>
    <label for="password">Password:</label> 
    <input type="password" id="password" name="password" required><br>
    <br>
    <label for="keyprogramming">Key Programming Language:</label> 
    <input type="text" id="keyprogramming" name="keyprogramming" placeholder="Python" required><br>
    <br>
    <label for="profile">Profile:</label> 
    <textarea id="profile" name="profile" rows="4" cols="50" placeholder="Put information about yourself here..."></textarea><br>
    <br>
    <label for="education">Education:</label> 
     <textarea id="education" name="education" rows="4" cols="50" placeholder="List your education details..."></textarea><br>
    <label for="links">URLs:</label> 
     <textarea id="links" name="links" rows="4" cols="50" placeholder="Provide some URLs where people can learn more about you..."></textarea><br>
     <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?? '' ?>">
    <input type="submit" value="Register"> 
</form>