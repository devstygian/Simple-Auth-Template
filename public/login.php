<?php
require_once '../includes/auth.php';

if (is_logged_in()) {
    redirect(APP_URL . '/main.php');
}

$error = get_flash('error');
$success = get_flash('success');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = login_user($_POST['email'] ?? '', $_POST['password'] ?? '');

    if ($result === true) {
        redirect(APP_URL . '/main.php');
    }

    $error = $result;
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
        <?php if (!empty($success)) : ?>
            <p style="color: green; text-align: center; margin-bottom: 20px;"><?php echo sanitize($success); ?></p>
        <?php endif; ?>
        <?php if (!empty($error)) : ?>
            <p style="color: red; text-align: center; margin-bottom: 20px;"><?php echo sanitize($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <button type="button" onclick="window.location.href='reset-password.php'">Forgot Password</button>
            <p>Don't have an account? Register <a href="register.php">here.</a></p>
        </form>
        <div class="auth-divider">or</div>
        <a class="google-button" href="google-login.php">Continue with Google</a>
    </div>
</body>

</html>
