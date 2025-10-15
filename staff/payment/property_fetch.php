<?php
require_once '../../classes/Database.php';
header('Content-Type: application/json');

$clientId = $_GET['client_id'] ?? null;

if (!$clientId) {
    echo json_encode(['success' => false, 'message' => 'Missing client_id']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            p.id,
            CONCAT('Lot ', p.lot, ' / Block ', p.block, ' (', p.location, ')') AS property_title
        FROM clients c
        INNER JOIN properties p ON c.property_id = p.id
        WHERE c.id = :client_id AND c.is_deleted = 0 AND p.is_deleted = 0
    ");
    $stmt->execute(['client_id' => $clientId]);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $properties]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
