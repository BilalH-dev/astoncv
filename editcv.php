<?php
session_start();
require("includes/db.php");

function escapedString($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function validateData($data) {
    $data = trim($data);
    return $data;
}

if (!isset($_SESSION['userid'])) {
    echo("You are not logged in.");
    exit();
}

else {
    $userid = $_SESSION['userid'];
    echo('<a href="index.php">Home</a> <a href="mycv.php">My CV</a> <a href="editcv.php">Edit CV</a> <a href="logout.php">Log Out</a>');
    echo("<h1>Edit CV</h1><p>Edit the information in your CV using the form below:</p>");
    $sql = "SELECT id, name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $getCv = $db->prepare($sql);
    $getCv->execute([$userid]);
    $cv = $getCv->fetch();
}

$errors = [];
$id = $_SESSION['userid'];
$name = $email = $keyprogramming = $profile = $education = $URLlinks = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $checkEmailsql = "SELECT id FROM cvs WHERE email = ? AND id != ?";
        $checkEmail = $db->prepare($checkEmailsql);
        $checkEmail->execute([$email, $id]);
        if ($checkEmail->rowCount() != 0) {
            $errors["email"] = "Email is already associated with another account";
            echo $errors["email"];
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
    $sql = "UPDATE cvs SET name=?, email=?, keyprogramming=?, profile=?, education=?, URLlinks=? WHERE id=?";
    $editCv = $db -> prepare($sql);
    $editCv -> execute([$name, $email, $keyprogramming, $profile, $education, $URLlinks, $id]);
    header("Location: mycv.php");
        }
    }
}
?>


<form action="editcv.php" method="post"> 
    <label for="name">Name:</label> 
    <input type="text" id="name" name="name" placeholder="Joe Bloggs" value="<?php echo escapedString($cv['name']); ?>" required><br>
    <br>
    <label for="email">Email:</label> 
    <input type="email" id="email" name="email" placeholder="joebloggs12@example.com" value="<?php echo escapedString($cv['email']); ?>" required><br>
    <br>
    <!-- Implement change password functionality -->
    <label for="keyprogramming">Key Programming Language:</label> 
    <input type="text" id="keyprogramming" name="keyprogramming" placeholder="Python" value="<?php echo escapedString($cv['keyprogramming']); ?>" required><br>
    <br>
    <label for="profile">Profile:</label> 
    <textarea id="profile" name="profile" rows="4" cols="50" placeholder="Put information about yourself here..."><?php echo escapedString($cv['profile']); ?></textarea><br>
    <br>
    <label for="education">Education:</label> 
     <textarea id="education" name="education" rows="4" cols="50" placeholder="List your education details..."><?php echo escapedString($cv['education']); ?></textarea><br>
    <label for="links">URLs:</label> 
     <textarea id="links" name="links" rows="4" cols="50" placeholder="Provide some URLs where people can learn more about you..."><?php echo escapedString($cv['URLlinks']); ?></textarea><br><br>
    <input type="submit" value="Update CV"> 
</form>