<?php
include '../includes/config.php';
checkLogin(); // Ensure the user is logged in before accessing this page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 2</title>
</head>
<body>
    Welcome to Page 2! This page is accessible only to logged-in users.
</body>
</html>