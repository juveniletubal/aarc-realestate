<?php
session_start();
require_once '../../classes/Database.php';
header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? 0;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, firstname, lastname, contact, email, address, facebook_link, role, username, image FROM users WHERE id = ? AND is_deleted = 0");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) throw new Exception('User not found');
    echo json_encode(['success' => true, 'data' => $user]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
