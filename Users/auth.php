<?php
/**
 * Protects user pages — only logged-in users can access.
 * Include at the very top of every page except login, signup, logout.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/site_settings.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
