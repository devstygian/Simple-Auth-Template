<?php
function sanitize($input)
{
    return htmlspecialchars(trim((string) $input), ENT_QUOTES, 'UTF-8');
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function set_flash($type, $message)
{
    $_SESSION['flash'][$type] = $message;
}

function get_flash($type)
{
    if (!isset($_SESSION['flash'][$type])) {
        return null;
    }

    $message = $_SESSION['flash'][$type];
    unset($_SESSION['flash'][$type]);

    return $message;
}
