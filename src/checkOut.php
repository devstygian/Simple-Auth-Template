<?php
require_once '../includes/auth.php';
auth_guard();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <p>Welcome, <?php echo sanitize($_SESSION['username']); ?>. This page is only available when you are logged in.</p>
    <p><a href="../main.php">Back to home</a></p>
</body>
</html>
