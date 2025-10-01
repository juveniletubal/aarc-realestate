<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        SELECT id, 
               CONCAT('Lot ', lot, ' / Block ', block) AS label, 
               price, location
        FROM properties 
        WHERE status = 'available' AND is_deleted = 0
    ");
    $stmt->execute();
    $property = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $property]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
