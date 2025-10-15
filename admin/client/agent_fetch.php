<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, CONCAT(firstname, ' ', lastname) AS agent_name
                       FROM users 
                       WHERE role IN ('staff', 'agent') AND is_deleted = 0");
    $stmt->execute();
    $agent = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $agent]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
