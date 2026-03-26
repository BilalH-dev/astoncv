<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

// Check if user is logged in and retrieve CV information
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $sql = "SELECT id, name, email, keyprogramming, profile, education, URLlinks FROM cvs WHERE id = ?";
    $getCv = $db->prepare($sql);
    $getCv->execute([$userid]);
    $cv = $getCv->fetch();
} else {
    header("Location: login.php");
    exit();
}

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION["csrf-token"])) {
    $_SESSION["csrf-token"] = getRandomString(10);
}

// Initialize variables and error array
$errors = [];
$id = $_SESSION['userid'];
$name = $keyprogramming = $profile = $education = $URLlinks = "";

// Update form submission logic
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
    } }
    if (empty($_POST["keyprogramming"])) {
        $errors["keyprogramming"] = "<b>Key programming language:</b> Key programming language is required";
    } else {
        $keyprogramming = validateData($_POST["keyprogramming"]);
    }
    if (!isset($_POST["profile"])) {
        $profile = "";
    }
    elseif ((strlen($_POST["profile"])) > 500) {
        $errors["profile"] = "<b>Invalid profile:</b> Profile text must be less than 500 characters long";
    }
    else {
        $profile = validateData($_POST["profile"]);
    }
    if (!isset($_POST["education"])) {
        $education = "";
    }
    elseif ((strlen($_POST["education"])) > 500) {
        $errors["education"] = "<b>Invalid education:</b> Education text must be less than 500 characters long";
    }
    else {
        $education = validateData($_POST["education"]);
    }
    if (!isset($_POST["links"])) {
        $URLlinks = "";
    }
    elseif ((strlen($_POST["links"])) > 500) {
        $errors["links"] = "<b>Invalid links:</b> Links field must be less than 500 characters long";
    }
    else {
        $URLlinks = validateData($_POST["links"]);
    }

    // If there are no errors, update the CV in the database
    if (empty($errors)) {
        $sql = "UPDATE cvs SET name=?, keyprogramming=?, profile=?, education=?, URLlinks=? WHERE id=?";
        $editCv = $db -> prepare($sql);
        $editCv -> execute([$name, $keyprogramming, $profile, $education, $URLlinks, $id]);
        // Redirect to the CV page after update
        header("Location: mycv.php");
        exit();
        }
    }
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
    include 'includes/header-user.php';
    ?>
    </header>
    <section class="main">
    <h1>Edit CV</h1>
    <p>Edit the information in your CV using the form below:</p>
    <?php
    if (!empty($errors)) {
        echo "<section id='error-section'>";
        echo "<p class='error-title'>There were errors with your submission and your CV was not updated, please correct the errors below:</p>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . escapedString($error) . "</li>";
        }
        echo "</ul>";
        echo "</section>";
    }
    ?>
    <form action="editcv.php" method="post"> 
        <h2>Core Information (Required)</h2>
        <label for="name">Name: <span class="asterisk">*</span></label> 
        <input type="text" size="49" id="name" name="name" placeholder="Joe Bloggs" title="Full Name" value="<?php echo escapedString($cv['name']); ?>" required><br>
        <br>
        <label for="email">Email: <span class="asterisk">*</span></label> 
        <input type="email" size="50" id="email" name="email" placeholder="joebloggs12@example.com" title="Email address cannot be edited after account creation." value="<?php echo escapedString($cv['email']); ?>" required disabled><br>
        <br>
        <label for="keyprogramming">Key Programming Language: <span class="asterisk">*</span></label> 
        <input type="text" size="28" id="keyprogramming" name="keyprogramming" placeholder="Python" title="Key Programming Language (e.g., Python, Java, C++)" value="<?php echo escapedString($cv['keyprogramming']); ?>" required><br>
        <br>
        <h2 for="profile">Profile</h2> 
        <textarea id="profile" name="profile" rows="4" cols="100" placeholder="Put information about yourself here..." title="Profile information"><?php echo escapedString($cv['profile']); ?></textarea><br>
        <br>
        <h2 for="education">Education</h2> 
        <textarea id="education" name="education" rows="4" cols="100" placeholder="List your education details..." title="Education information"><?php echo escapedString($cv['education']); ?></textarea><br>
        <br>
        <h2 for="links">Links (URLs)</h2> 
        <textarea id="links" name="links" rows="4" cols="100" placeholder="Provide some links where people can learn more about you..." title="URLs"><?php echo escapedString($cv['URLlinks']); ?></textarea><br><br>
        <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?? '' ?>">
        <input type="submit" value="Update CV"> 
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </section>
</body>
</html>