<?php
require_once 'db.php';
require_once 'functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function register_user($username, $email, $password)
{
    global $conn;

    $username = sanitize($username);
    $email = sanitize($email);

    if ($username === '' || $email === '' || $password === '') {
        return 'All fields are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Please enter a valid email address.';
    }

    $check = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        return 'That email is already registered.';
    }
    $check->close();

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $insert = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $insert->bind_param('sss', $username, $email, $hash);

    if ($insert->execute()) {
        $insert->close();
        return true;
    }

    $insert->close();
    return 'Unable to register. Please try again later.';
}

function login_user($email, $password)
{
    global $conn;

    $email = sanitize($email);

    $stmt = $conn->prepare('SELECT id, username, password, provider FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        start_user_session($user);
        return true;
    }

    if ($user && ($user['provider'] ?? '') === 'google') {
        return 'This account uses Google sign-in. Click Login with Google.';
    }

    return 'Invalid email or password';
}

function start_user_session($user)
{
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
}

function login_with_google($google_id, $email, $name)
{
    global $conn;

    $google_id = sanitize($google_id);
    $email = sanitize($email);
    $name = sanitize($name);

    if ($google_id === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Google did not return a valid account.';
    }

    $stmt = $conn->prepare('SELECT id, username FROM users WHERE provider = ? AND provider_id = ?');
    $provider = 'google';
    $stmt->bind_param('ss', $provider, $google_id);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($existing) {
        start_user_session($existing);
        return true;
    }

    $stmt = $conn->prepare('SELECT id, username FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $by_email = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($by_email) {
        $link = $conn->prepare('UPDATE users SET provider = ?, provider_id = ? WHERE id = ?');
        $link->bind_param('ssi', $provider, $google_id, $by_email['id']);
        $link->execute();
        $link->close();
        start_user_session($by_email);
        return true;
    }

    $username = make_unique_username($name !== '' ? $name : strtok($email, '@'));
    $placeholder_password = password_hash(bin2hex(random_bytes(32)), PASSWORD_BCRYPT);

    $insert = $conn->prepare(
        'INSERT INTO users (username, email, password, provider, provider_id) VALUES (?, ?, ?, ?, ?)'
    );
    $insert->bind_param('sssss', $username, $email, $placeholder_password, $provider, $google_id);

    if (!$insert->execute()) {
        $insert->close();
        return 'Unable to create your account from Google. Please try again.';
    }

    $new_user = [
        'id' => $insert->insert_id,
        'username' => $username,
    ];
    $insert->close();
    start_user_session($new_user);
    return true;
}

function make_unique_username($name)
{
    global $conn;

    $base = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $name));
    if ($base === '') {
        $base = 'user';
    }
    $base = substr($base, 0, 80);

    $username = $base;
    $tries = 0;
    while ($tries < 20) {
        $check = $conn->prepare('SELECT id FROM users WHERE username = ?');
        $check->bind_param('s', $username);
        $check->execute();
        $check->store_result();
        $taken = $check->num_rows > 0;
        $check->close();

        if (!$taken) {
            return $username;
        }

        $username = $base . random_int(1000, 9999);
        $tries++;
    }

    return $base . bin2hex(random_bytes(3));
}

function is_logged_in()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function auth_guard()
{
    if (!is_logged_in()) {
        redirect(BASE_URL . '/login.php');
    }
}

function logout_user()
{
    session_unset();
    session_destroy();
    redirect(BASE_URL . '/login.php');
}

function checkLogin()
{
    auth_guard();
}
