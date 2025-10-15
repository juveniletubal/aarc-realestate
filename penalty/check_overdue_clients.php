<?php
require_once '../classes/Database.php';

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        SELECT id, balance, penalty, first_payment_date, last_penalty_date
        FROM clients
        WHERE balance > 0
          AND first_payment_date < CURDATE()
          AND (last_penalty_date IS NULL OR MONTH(last_penalty_date) < MONTH(CURDATE()))
    ");
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results = [];

    foreach ($clients as $client) {
        $clientId = $client['id'];
        $balance = (float)$client['balance'];
        $rate = (float)($client['penalty'] ?? 5);
        $dueDate = $client['first_payment_date'];

        // Calculate months overdue
        $due = new DateTime($dueDate);
        $now = new DateTime();
        $interval = $due->diff($now);
        $monthsOverdue = ($interval->y * 12) + $interval->m;
        if ($monthsOverdue < 1) $monthsOverdue = 1;

        // Compute penalty
        $penaltyAmount = round($balance * ($rate / 100) * $monthsOverdue, 2);
        $newBalance = round($balance + $penaltyAmount, 2);

        // Update client
        $update = $pdo->prepare("
            UPDATE clients
            SET balance = ?, 
                is_overdue = 1,
                last_penalty_date = CURDATE(),
                updated_at = NOW()
            WHERE id = ?
        ");
        $update->execute([$newBalance, $clientId]);

        // Log penalty in history table
        $log = $pdo->prepare("
            INSERT INTO penalties (client_id, penalty_amount, rate, months_overdue, date_applied)
            VALUES (?, ?, ?, ?, CURDATE())
        ");
        $log->execute([$clientId, $penaltyAmount, $rate, $monthsOverdue]);

        // Store result for response
        $results[] = [
            'client_id' => $clientId,
            'old_balance' => $balance,
            'penalty_added' => $penaltyAmount,
            'months_overdue' => $monthsOverdue,
            'new_balance' => $newBalance
        ];
    }

    $pdo->commit();

    $logFile = __DIR__ . '/penalty_log.txt';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Updated " . count($results) . " clients\n", FILE_APPEND);

    echo json_encode([
        'success' => true,
        'message' => 'Overdue clients updated successfully.',
        'data' => $results
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    file_put_contents(__DIR__ . '/penalty_log.txt', date('Y-m-d H:i:s') . " - ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
