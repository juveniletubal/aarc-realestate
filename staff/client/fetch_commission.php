<?php
require_once '../../classes/Database.php';
header('Content-Type: application/json');

$comRef = $_GET['com_ref'] ?? '';

if (empty($comRef)) {
    echo json_encode(['success' => false, 'message' => 'Missing com_ref']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            c.user_id,
            c.role,
            c.percent,
            c.term,
            CONCAT(u.firstname, ' ', u.lastname) AS user_name
        FROM commissions c
        LEFT JOIN users u ON c.user_id = u.id
        WHERE c.com_ref = :com_ref
    ");
    $stmt->execute([':com_ref' => $comRef]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        'director' => 'director',
        'manager' => 'manager',
        'downline' => 'downline',
        'term' => null
    ];

    foreach ($rows as $r) {
        if (isset($data[$r['role']])) {
            $data[$r['role']] = [
                'user_id' => $r['user_id'],
                'percent' => $r['percent'],
                'user_name' => $r['user_name']
            ];
        }
        $data['term'] = $r['term'];
    }

    echo json_encode(['success' => true, 'data' => $data]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
