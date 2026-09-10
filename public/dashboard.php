<?php
require_once '../includes/auth.php';
auth_guard();
$page_title = 'Dashboard';
require_once '../templates/header.php';
?>

<div class="login-card">
    <h2>Welcome, <?php echo sanitize($_SESSION['username']); ?></h2>
    <p style="text-align: center; margin-bottom: 20px;">You are logged in.</p>
    <p style="text-align: center; margin-bottom: 12px;">
        <a href="<?php echo APP_URL; ?>/main.php">Go to restaurant</a>
    </p>
    <p style="text-align: center;">
        <a href="<?php echo BASE_URL; ?>/logout.php">Log out</a>
    </p>
</div>

<?php require_once '../templates/footer.php'; ?>
