<?php
// Encode HTML tags as literal characters
function escapedString($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Remove leading and trailing whitespace
function validateData($data) {
    $data = trim($data);
    return $data;
}

// Generate a random string
function getRandomString($n) {
    return bin2hex(random_bytes($n / 2));
}
?>