<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, CONCAT(lastname, ', ', firstname) AS name 
                           FROM agents 
                           WHERE position = 'director' AND is_deleted = 0");
    $stmt->execute();
    $directors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $directors]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
