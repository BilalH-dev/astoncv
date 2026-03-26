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
$name = $email = $password = $keyprogramming = $profile = $education = $URLlinks = "";

// Registration form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf-token"]) || $_POST["csrf-token"] != $_SESSION["csrf-token"]) {
        $errors["misc"] = "<b>Unexpected error:</b> An unexpected error occurred. Please try again.";
        http_response_code(403);
    }
    if (empty($_POST["name"])) {
        $errors["name"] = "<b>Name:</b> Name is required";
    } else {
        $name = validateData($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $errors["name"] = "<b>Invalid name:</b> Name must only contain letters and whitespace";
    } 
    
    }
    if (empty($_POST["email"])) {
        $errors["email"] = "<b>Email:</b> Email is required";
    }
        else {
        $email = validateData($_POST["email"]);
        // Check whether if email is already linked to an account
        $checkEmailsql = "SELECT email FROM cvs WHERE email = ?";
        $checkEmail = $db->prepare($checkEmailsql);
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() != 0) {
            $errors["email"] = "<b>Invalid email:</b> An account with this email already exists";
            }
        }
    if (empty($_POST["password"])) {
        $errors["password"] = "<b>Password:</b> Password is required";
    } else {
        $password = validateData($_POST["password"]);
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($_POST["keyprogramming"])) {
        $errors["keyprogramming"] = "<b>Key programming language:</b> Key programming language is required";
    } else {
        $keyprogramming = validateData($_POST["keyprogramming"]);
    }
    if (!isset($_POST["profile"])) {
        $profile = "";
    }
    elseif ((strlen($_POST["profile"])) > 500) {
        $errors["profile"] = "<b>Invalid profile:</b> Profile text must be less than 500 characters";
    }
    else {
        $profile = validateData($_POST["profile"]);
    }
    if (!isset($_POST["education"])) {
        $education = "";
    }
    elseif ((strlen($_POST["education"])) > 500) {
        $errors["education"] = "<b>Invalid education:</b> Education text must be less than 500 characters";
    }
    else {
        $education = validateData($_POST["education"]);
    }
    if (!isset($_POST["links"])) {
        $URLlinks = "";
    }
    elseif ((strlen($_POST["links"])) > 500) {
        $errors["links"] = "<b>Invalid links:</b> Links field must be less than 500 characters";
    }
    else {
        $URLlinks = validateData($_POST["links"]);
    }

    // Create the user account if there are no errors in the submission
    if (empty($errors)) {
    $sql = "INSERT INTO cvs (name, email, password, keyprogramming, profile, education, URLlinks) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $register = $db -> prepare($sql);
    $register -> execute([$name, $email, $password, $keyprogramming, $profile, $education, $URLlinks]);
    // Get the user ID of the newly created account, store it in the session variable and redirect to CV page
    $userId = $db->lastInsertId();
    $_SESSION["userid"] = $userId;
    header("Location: mycv.php");
    exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en-gb">
<head>
    <html lang="en-gb">
    <title>AstonCV | Register</title>
    <link rel="stylesheet" type="text/css" href="assets/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
<body>
    <header>
    <?php
    include 'includes/header-guest.php';
    ?>
    </header>
    <section class="main">
        <h1>Register</h1>
        <p>You can create an account here to create and manage your CV.<br><em>Required fields are marked with an asterisk (<span class="asterisk">*</span>).</em></p>
        <p><em>Already have an account?</em> <a href="login.php"><b>Log in here</b></a>.</p>
        <?php
        // Display errors if there are any
        if (!empty($errors)) {
            echo "<section id='error-section'>";
            echo "<p class='error-title'>There were errors with your submission and your account was not created, please correct the errors below:</p>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>";
                }
            echo "</ul>";
            echo "</section>";
        }
        ?>
        <form action="register.php" method="post"> 
            <h2>Core Information</h2>
            <label for="name">Name: <span class="asterisk">*</span></label> 
            <input type="text" size="49" id="name" name="name" placeholder="Joe Bloggs" title="Full Name" required><br>
            <br>
            <label for="email">Email:</label> <span class="asterisk">*</span>
            <input type="email" size="50" id="email" name="email" placeholder="joebloggs12@example.com" title="Email Address" required><br>
            <br>
            <label for="password">Password:</label> <span class="asterisk">*</span>
            <input type="password" size="46" id="password" name="password" title="Password" required><br>
            <br>
            <label for="keyprogramming">Key Programming Language:</label> <span class="asterisk">*</span>
            <input type="text" size="28" id="keyprogramming" name="keyprogramming" title="Key Programming Language (e.g., Python, Java, C++)"placeholder="Python" required><br>
            <br>
            <h2 for="profile">Profile</h2> 
            <textarea id="profile" name="profile" rows="4" cols="100" placeholder="Put information about yourself here..." title="Profile information"></textarea><br>
            <br>
            <h2 for="education">Education</h2> 
            <textarea id="education" name="education" rows="4" cols="100" placeholder="List your education details..." title="Education information"></textarea><br>
            <br>
            <h2 for="links">Links (URLs)</h2> 
            <textarea id="links" name="links" rows="4" cols="100" placeholder="Provide some links where people can learn more about you..." title="URLs"></textarea><br>
            <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?? '' ?>">
            <br>
            <input type="submit" value="Register"> 
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>