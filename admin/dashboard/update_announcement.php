<?php
require_once '../../classes/Database.php';
header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

if (empty($title) || empty($content)) {
    echo json_encode(["success" => false, "message" => "Title and content are required."]);
    exit;
}

$stmt = $pdo->prepare("UPDATE announcements 
                       SET title = ?, content = ?, updated_at = NOW() 
                       WHERE id = 1");
$success = $stmt->execute([$title, $content]);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Announcement updated successfully" : "Failed to update announcement"
]);
