<?php
require_once '../includes/auth.php';

if (is_logged_in()) {
    redirect(APP_URL . '/main.php');
}

$error = get_flash('error');
$success = get_flash('success');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = login_user(
        $_POST['email'] ?? '',
        $_POST['password'] ?? ''
    );

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

    <title>Login | Nadine's Catering</title>

    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>

    <div class="auth-page">

        <!-- ===== BRANDING SIDE ===== -->
        <div class="branding-side">

            <div class="branding-image"></div>

        </div>


        <!-- ===== FORM SIDE ===== -->
        <div class="form-side">

            <div class="auth-card">

                <div class="mobile-brand">
                    <h1>Nadine's</h1>
                    <span>CATERING</span>
                </div>

                <div class="auth-header">
                    <h2>Welcome Back</h2>
                    <p>Login to continue ordering your favorite food.</p>
                </div>


                <!-- ===== SUCCESS MESSAGE ===== -->
                <?php if (!empty($success)) : ?>

                    <div class="message success-message">
                        <?php echo sanitize($success); ?>
                    </div>

                <?php endif; ?>


                <!-- ===== ERROR MESSAGE ===== -->
                <?php if (!empty($error)) : ?>

                    <div class="message error-message">
                        <?php echo sanitize($error); ?>
                    </div>

                <?php endif; ?>


                <!-- ===== LOGIN FORM ===== -->
                <form method="POST" class="auth-form">

                    <div class="form-group">

                        <label for="email">Email</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            autocomplete="email"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    <div class="forgot-password">

                        <a href="reset-password.php">
                            Forgot Password?
                        </a>

                    </div>


                    <button type="submit" class="primary-button">
                        Login
                    </button>

                </form>


                <!-- ===== REGISTER LINK ===== -->
                <p class="account-text">

                    Don't have an account?

                    <a href="register.php">
                        Register
                    </a>

                </p>


                <!-- ===== DIVIDER ===== -->
                <div class="auth-divider">
                    <span>or</span>
                </div>


                <!-- ===== GOOGLE LOGIN ===== -->
                <a
                    class="google-button"
                    href="google-login.php"
                >
                    <span class="google-icon">G</span>
                    Continue with Google
                </a>


                <!-- ===== FOOTER ===== -->
                <p class="auth-footer">
                    Nadine's Catering
                </p>

            </div>

        </div>

    </div>

</body>

</html>