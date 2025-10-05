<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        SELECT 
            u.id, 
            CONCAT(u.firstname, ' ', u.lastname) AS client_name
        FROM clients c
        INNER JOIN users u ON c.user_id = u.id
        WHERE u.is_deleted = 0
    ");

    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $clients]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
