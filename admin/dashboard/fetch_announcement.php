<?php
require_once '../../classes/Database.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT title, content FROM announcements ORDER BY updated_at DESC LIMIT 1");
$announcement = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "title"   => $announcement ? $announcement['title'] : '',
    "content" => $announcement ? $announcement['content'] : ''
]);
