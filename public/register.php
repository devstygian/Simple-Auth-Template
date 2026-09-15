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

        set_flash(
            'success',
            'Registration successful. You can now log in.'
        );

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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register | Nadine's Catering</title>

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

                    <h2>Create Account</h2>

                    <p>
                        Create an account to start ordering.
                    </p>

                </div>


                <!-- ===== ERROR MESSAGE ===== -->
                <?php if (!empty($error)) : ?>

                    <div class="message error-message">

                        <?php echo sanitize($error); ?>

                    </div>

                <?php endif; ?>


                <!-- ===== REGISTER FORM ===== -->
                <form
                    method="POST"
                    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    class="auth-form"
                >

                    <div class="form-group">

                        <label for="username">
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

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

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Create a password"
                            autocomplete="new-password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Create Account
                    </button>

                </form>


                <!-- ===== LOGIN LINK ===== -->
                <p class="account-text">

                    Already have an account?

                    <a href="login.php">
                        Login
                    </a>

                </p>


                <!-- ===== DIVIDER ===== -->
                <div class="auth-divider">

                    <span>or</span>

                </div>


                <!-- ===== GOOGLE REGISTER ===== -->
                <a
                    class="google-button"
                    href="google-login.php"
                >

                    <span class="google-icon">
                        G
                    </span>

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