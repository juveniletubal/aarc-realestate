<?php
require_once '../../classes/Database.php';
header('Content-Type: application/json');

try {
    $clientId = isset($_GET['client_id']) ? (int) $_GET['client_id'] : 0;

    $params = [];
    $params[':client_id'] = $clientId > 0 ? $clientId : 0;

    $stmt = $pdo->prepare("
        SELECT 
            id, 
            CONCAT('Lot ', lot, ' , Block ', block) AS title,
            CONCAT(' - ', location, ' (', status, ')') AS label,
            price, 
            location,
            status
        FROM properties
        WHERE is_deleted = 0
          AND (
              status IN ('available', 'reserved', 'sold')
              OR id IN (SELECT property_id FROM clients WHERE id = :client_id)
          )
    ");
    $stmt->execute($params);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $properties
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
