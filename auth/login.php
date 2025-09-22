<?php
session_start();
require_once "../classes/Database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND is_active = 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Start session
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Handle Remember Me
        if ($remember) {
            $rawToken = bin2hex(random_bytes(32));
            $hashedToken = hash('sha256', $rawToken);

            // Set cookie (expires in 30 days)
            setcookie(
                "remember_token",
                $rawToken,
                [
                    'expires' => time() + 86400 * 30,
                    'path' => '/',
                    'secure' => false, // true if HTTPS
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]
            );

            // Save hashed token in DB
            $stmt = $pdo->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
            $stmt->execute(['token' => $hashedToken, 'id' => $user['id']]);
        } else {
            // Clear any previous Remember Me token
            setcookie("remember_token", "", time() - 3600, "/");
            $stmt = $pdo->prepare("UPDATE users SET remember_token = NULL WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);
        }

        // Redirect to dashboard
        switch ($user['role']) {
            case 'admin': header("Location: ../admin/"); break;
            case 'agent': header("Location: ../agent/"); break;
            default: header("Location: ../client/"); break;
        }
        exit;

    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: ../login");
        exit;
    }
}
