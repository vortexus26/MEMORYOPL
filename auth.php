<?php
// VORTEXUS 26 - proteksi halaman utama dengan login kelas.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    ]);
    session_start();
}

$allowedPasswords = [
    'PPLDG26'    => '$2y$12$hxfoTcFm4lrYCHo17YP2GOvuJdoRdFVLt6y5e8OvIJRejRWNKlwSC',
    'OTOMOTIF26' => '$2y$12$m5xthWGWD2x/i0uf.CaSL.g3EmoDOfxPmDfHPvXJ0ifsWNeYx3J5q',
    'ATPH26'     => '$2y$12$zSEs6vSjU58kp70E./7yVukm.c9hP9Uuc.1cX6VOdcTuBYaxOfBgC',
    'BUSANA26'   => '$2y$12$5FiJDBCiuH3igTAlnNKbIem1vr3dmOR4QWluLTB7OGDpRyvHyRiES',
];

function isLoggedIn(): bool {
    return !empty($_SESSION['vortexus_logged_in']) && !empty($_SESSION['vortexus_class']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function attemptLogin(string $class, string $password): bool {
    global $allowedPasswords;
    $class = trim($class);
    $password = trim($password);

    if (!isset($allowedPasswords[$class])) {
        return false;
    }

    if (!password_verify($password, $allowedPasswords[$class])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['vortexus_logged_in'] = true;
    $_SESSION['vortexus_class'] = $class;
    $_SESSION['vortexus_login_at'] = time();
    return true;
}
