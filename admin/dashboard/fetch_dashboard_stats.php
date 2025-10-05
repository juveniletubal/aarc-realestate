<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

try {
    // Users
    $stmtUsers = $pdo->prepare("
        SELECT 
            COUNT(*) AS total_users,
            SUM(CASE WHEN role = 'staff' THEN 1 ELSE 0 END) AS total_staff,
            SUM(CASE WHEN role = 'agent' THEN 1 ELSE 0 END) AS total_agent,
            SUM(CASE WHEN role = 'client' THEN 1 ELSE 0 END) AS total_client
        FROM users 
        WHERE is_deleted = 0
    ");
    $stmtUsers->execute();
    $users = $stmtUsers->fetch(PDO::FETCH_ASSOC);

    // Properties
    $stmtProps = $pdo->prepare("
        SELECT 
            COUNT(*) AS total_properties,
            SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) AS total_available,
            SUM(CASE WHEN status = 'reserved' THEN 1 ELSE 0 END) AS total_reserved,
            SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) AS total_sold
        FROM properties 
        WHERE is_deleted = 0
    ");
    $stmtProps->execute();
    $properties = $stmtProps->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'users' => $users,
        'properties' => $properties
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
