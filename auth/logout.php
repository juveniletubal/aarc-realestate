<?php
session_start();
require_once "../classes/Database.php";

$stmt = $pdo->prepare("UPDATE users SET is_active = 0 WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);

// Destroy session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login
header("Location: ../login");
exit;
