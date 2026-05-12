<?php
//database connection
$conn = new mysqli("localhost", "root", "", "authdb");

//silence error reporting for production
error_reporting(0);
ini_set('display_errors', 0);

//base URL for redirects
$base_url = "http://localhost/git-projects/Simple-Auth-Template/";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//function to check if user is logged in
function checkLogin() {
    global $base_url;
    if (!isset($_SESSION['users']) || empty($_SESSION['users'])) {
        header("Location: {$base_url}public/login.php");
        exit(); 
    }
}

// Role-based access control function
function checkRole($roles = [])
{
    global $base_url;

    if (!is_array($roles)) {
        $roles = explode(',', $roles);
    }

    $roles = array_map('trim', $roles);

    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $roles, true)) {
        header("Location: {$base_url}auth/unauthorized.php");
        exit();
    }
}
?>