<?php
require_once '../includes/auth.php';

if (is_logged_in()) {
    redirect(APP_URL . '/main.php');
}

redirect(BASE_URL . '/login.php');
