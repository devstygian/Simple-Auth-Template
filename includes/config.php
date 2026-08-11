<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "authdb"
);

//
error_reporting(0);
ini_set('display_errors', 0);

$base_url = "http://localhost/git-projects/Simple-Auth-Template/";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function checkLogin()
{
    global $base_url;

    if (!isset($_SESSION['users']) || empty($_SESSION['users'])) {
        header("Location: {$base_url}public/login.php");
        exit();
    }
}
