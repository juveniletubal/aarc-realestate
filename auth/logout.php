<?php
session_start();
require_once "../classes/Database.php";

// If user logged in, clear their remember_token in DB
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("UPDATE users SET remember_token = NULL WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
}

// Destroy session completely
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Clear remember me cookie
setcookie("remember_token", "", time() - 3600, "/", "", true, true);

// Redirect to login page
header("Location: ../login");
exit;
