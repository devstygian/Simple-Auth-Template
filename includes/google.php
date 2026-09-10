<?php
require_once 'auth.php';

function google_is_configured()
{
    return GOOGLE_CLIENT_ID !== '' && GOOGLE_CLIENT_SECRET !== '';
}

function google_start_login()
{
    if (!google_is_configured()) {
        set_flash('error', 'Google login is not configured yet. Add GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in includes/config.php.');
        redirect(BASE_URL . '/login.php');
    }

    $_SESSION['google_oauth_state'] = bin2hex(random_bytes(16));

    $params = http_build_query([
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'openid email profile',
        'state' => $_SESSION['google_oauth_state'],
        'access_type' => 'online',
        'prompt' => 'select_account',
    ]);

    redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $params);
}

function google_complete_login($code, $state)
{
    if (!google_is_configured()) {
        return 'Google login is not configured.';
    }

    $expected = $_SESSION['google_oauth_state'] ?? '';
    unset($_SESSION['google_oauth_state']);

    if ($expected === '' || !hash_equals($expected, (string) $state)) {
        return 'Google sign-in was cancelled or could not be verified. Please try again.';
    }

    if ($code === '') {
        return 'Google did not return an authorization code.';
    }

    $token = google_http_post('https://oauth2.googleapis.com/token', [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'grant_type' => 'authorization_code',
    ]);

    if (!$token || empty($token['access_token'])) {
        $detail = $token['error_description'] ?? $token['error'] ?? 'token exchange failed';
        return 'Could not connect to Google (' . $detail . ').';
    }

    $profile = google_http_get(
        'https://www.googleapis.com/oauth2/v3/userinfo',
        $token['access_token']
    );

    if (!$profile || empty($profile['sub']) || empty($profile['email'])) {
        return 'Google did not return your email. Allow email access and try again.';
    }

    if (isset($profile['email_verified']) && $profile['email_verified'] !== true && $profile['email_verified'] !== 'true') {
        return 'Your Google email is not verified.';
    }

    return login_with_google(
        $profile['sub'],
        $profile['email'],
        $profile['name'] ?? $profile['given_name'] ?? ''
    );
}

function google_http_post($url, $fields)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($fields),
        CURLOPT_HTTPHEADER => ['Accept: application/json'],
        CURLOPT_TIMEOUT => 20,
    ]);

    $body = curl_exec($ch);
    curl_close($ch);

    if ($body === false) {
        return null;
    }

    $data = json_decode($body, true);
    return is_array($data) ? $data : null;
}

function google_http_get($url, $access_token)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Authorization: Bearer ' . $access_token,
        ],
        CURLOPT_TIMEOUT => 20,
    ]);

    $body = curl_exec($ch);
    curl_close($ch);

    if ($body === false) {
        return null;
    }

    $data = json_decode($body, true);
    return is_array($data) ? $data : null;
}
