<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'simple_auth');
define('BASE_URL', 'http://localhost/git-projects/Simple-Auth-Template/public');
define('APP_URL', 'http://localhost/git-projects/Simple-Auth-Template');

require_once __DIR__ . '/config.local.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
