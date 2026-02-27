<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "astoncv";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Database connection failed.");
}