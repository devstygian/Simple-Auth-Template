<?php
require_once '../includes/google.php';

if (isset($_GET['error'])) {
    set_flash('error', 'Google sign-in was cancelled.');
    redirect(BASE_URL . '/login.php');
}

$result = google_complete_login($_GET['code'] ?? '', $_GET['state'] ?? '');

if ($result === true) {
    redirect(APP_URL . '/main.php');
}

set_flash('error', is_string($result) ? $result : 'Google sign-in failed.');
redirect(BASE_URL . '/login.php');
