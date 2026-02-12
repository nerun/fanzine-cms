<?php
session_start();

if (!isset($_SESSION['menuOpen'])) {
    $_SESSION['menuOpen'] = false;
}

$_SESSION['menuOpen'] = !$_SESSION['menuOpen'];

$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';

header('Location: ' . $redirect);
exit;
