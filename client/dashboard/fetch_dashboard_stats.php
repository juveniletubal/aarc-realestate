<?php
require_once '../../classes/Database.php';

header('Content-Type: application/json');

$userId = $_POST['user_id'] ?? $_GET['user_id'] ?? '';

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

    // Payment
    $stmtTotalPayment = $pdo->prepare("
        SELECT SUM(p.amount_paid) AS total_payment_paid
        FROM payments p
        JOIN clients c ON p.client_id = c.id
        WHERE p.is_deleted = 0 AND c.user_id = ?
    ");
    $stmtTotalPayment->execute([$userId]);
    $payments = $stmtTotalPayment->fetch(PDO::FETCH_ASSOC);

    // Properties
    $stmtTotal = $pdo->prepare("
        SELECT 
            SUM(total_price) AS total_properties_price
        FROM clients
        WHERE first_payment_date != NULL AND is_deleted = 0 AND user_id = ?
    ");
    $stmtTotal->execute([$userId]);
    $totals = $stmtTotal->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'payments' => $payments,
        'totals' => $totals
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
