<?php
require_once '../../classes/Database.php';
header('Content-Type: application/json');

try {
    // Get client ID if provided (for edit mode)
    $clientId = isset($_GET['client_id']) ? (int) $_GET['client_id'] : 0;

    $params = [];
    $extraPropertyCondition = "";

    // If editing, include the client's current property even if it's reserved/sold
    if ($clientId > 0) {
        $extraPropertyCondition = "OR id = (SELECT property_id FROM clients WHERE id = :client_id)";
        $params[':client_id'] = $clientId;
    }

    $stmt = $pdo->prepare("
        SELECT 
            id, 
            CONCAT('Lot ', lot, ' / Block ', block, ' (', location, ')') AS label, 
            price, 
            location,
            status
        FROM properties
        WHERE (status = 'available' $extraPropertyCondition)
          AND is_deleted = 0
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
