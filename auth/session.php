<?php
ini_set('session.cookie_lifetime', 0);
session_start();

require_once __DIR__ . '/../classes/Database.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $rawToken = $_COOKIE['remember_token'];
    $hashedToken = hash('sha256', $rawToken);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = :token AND is_active = 1");
    $stmt->execute(['token' => $hashedToken]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
    }
}
