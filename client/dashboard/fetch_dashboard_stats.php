<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

try {
    // Users
    // $stmtUsers = $pdo->prepare("
    //     SELECT 
    //         COUNT(*) AS total_users,
    //         SUM(CASE WHEN role = 'staff' THEN 1 ELSE 0 END) AS total_staff,
    //         SUM(CASE WHEN role = 'agent' THEN 1 ELSE 0 END) AS total_agent,
    //         SUM(CASE WHEN role = 'client' THEN 1 ELSE 0 END) AS total_client
    //     FROM users 
    //     WHERE is_deleted = 0
    // ");
    // $stmtUsers->execute();
    // $users = $stmtUsers->fetch(PDO::FETCH_ASSOC);

    // Properties
    $stmtTotal = $pdo->prepare("
         SELECT 
            COUNT(DISTINCT user_id) AS total_clients,
            COUNT(*) AS total_client_records,
            SUM(balance) AS total_properties_price
        FROM clients
    WHERE is_deleted = 0
    ");
    $stmtTotal->execute();
    $totals = $stmtTotal->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        // 'users' => $users,
        'totals' => $totals
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
