<?php
// login.php
include '../includes/config.php';

//start session and check if user is already logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//if already logged in, redirect to main page
if (isset($_SESSION['users']) && !empty($_SESSION['users'])) {
    header('Location: main.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // prepared statement to petch user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        // valid login
        $_SESSION['users'] = $user; // store user data in session
        header('Location: main.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>
    <div class="login-card">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>