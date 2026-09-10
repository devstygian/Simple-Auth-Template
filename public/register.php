<?php
require_once '../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = register_user(
        $_POST['username'] ?? '',
        $_POST['email'] ?? '',
        $_POST['password'] ?? ''
    );

    if ($result === true) {
        set_flash('success', 'Registration successful. You can now log in.');
        redirect(BASE_URL . '/login.php');
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="login-card">
        <h2>Register</h2>
        <?php if (!empty($error)) : ?>
            <p style="color: red; text-align: center; margin-bottom: 20px;"><?php echo sanitize($error); ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
        <div class="auth-divider">or</div>
        <a class="google-button" href="google-login.php">Continue with Google</a>
    </div>
</body>
</html>
