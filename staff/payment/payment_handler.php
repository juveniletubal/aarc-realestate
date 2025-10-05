<?php
require_once '../../classes/Database.php';

class PaymentHandler
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function handleRequest()
    {
        header('Content-Type: application/json');

        $action = $_POST['action'] ?? $_GET['action'] ?? '';

        try {
            switch ($action) {
                case 'insert':
                    $this->insertData();
                    break;
                case 'update':
                    $this->updateData();
                    break;
                case 'delete':
                    $this->deleteData();
                    break;
                case 'get':
                    $this->getData();
                    break;
                case 'list':
                    $this->listData();
                    break;
                default:
                    throw new Exception('Invalid action');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function validateInput($data, $id = null)
    {
        $required = ['client_id', 'amount', 'date_paid'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required.');
            }
        }
    }

    private function insertData()
    {
        try {
            $this->validateInput($_POST);

            $clientId = $_POST['client_id'];
            $amount = $_POST['amount'];
            $datePaid = $_POST['date_paid'];

            // 1️⃣ Check if client exists and fetch first_payment_date
            $stmt = $this->pdo->prepare("SELECT first_payment_date FROM clients WHERE id = ?");
            $stmt->execute([$clientId]);
            $client = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$client) {
                throw new Exception("Client not found.");
            }

            // 2️⃣ Insert payment record
            $stmt = $this->pdo->prepare("
            INSERT INTO payments (client_id, amount_paid, payment_date, created_at, updated_at)
            VALUES (?, ?, ?, NOW(), NOW())
        ");
            $stmt->execute([$clientId, $amount, $datePaid]);

            // 3️⃣ If first_payment_date is NULL → set it to this date
            if (empty($client['first_payment_date'])) {
                $stmt = $this->pdo->prepare("
                UPDATE clients
                SET first_payment_date = ?
                WHERE id = ?
            ");
                $stmt->execute([$datePaid, $clientId]);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Payment recorded successfully.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function updateData()
    {
        try {
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) throw new Exception('Invalid payment ID.');

            $this->validateInput($_POST, $id);

            $clientId = $_POST['client_id'];
            $amount = $_POST['amount'];
            $datePaid = $_POST['date_paid'];

            // Check if the payment exists
            $stmt = $this->pdo->prepare("SELECT * FROM payments WHERE id = ?");
            $stmt->execute([$id]);
            $existingPayment = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingPayment) {
                throw new Exception("Payment record not found.");
            }

            // Get client info (for first_payment_date)
            $stmt = $this->pdo->prepare("SELECT first_payment_date FROM clients WHERE id = ?");
            $stmt->execute([$clientId]);
            $client = $stmt->fetch(PDO::FETCH_ASSOC);

            // Track if we need to update client's first_payment_date
            $shouldUpdateFirstDate = false;

            if (!empty($client['first_payment_date'])) {
                // If the client's first payment date matches the old payment date,
                // update it to the new one
                if ($client['first_payment_date'] === $existingPayment['payment_date']) {
                    $shouldUpdateFirstDate = true;
                }
            }

            // Update the payment record
            $stmt = $this->pdo->prepare("
            UPDATE payments
            SET client_id = ?, amount = ?, payment_date = ?, updated_at = NOW()
            WHERE id = ?
        ");
            $stmt->execute([$clientId, $amount, $datePaid, $id]);

            // If needed, update the client's first payment date too
            if ($shouldUpdateFirstDate) {
                $stmt = $this->pdo->prepare("
                UPDATE clients
                SET first_payment_date = ?
                WHERE id = ?
            ");
                $stmt->execute([$datePaid, $clientId]);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Payment updated successfully.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function deleteData()
    {
        try {
            $id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
            if (!$id) throw new Exception('Invalid payment ID');

            $stmt = $this->pdo->prepare("SELECT * FROM payments WHERE id = ?");
            $stmt->execute([$id]);
            $payment = $stmt->fetch();
            if (!$payment) throw new Exception('Payment not found');

            $this->pdo->prepare("UPDATE payments SET is_deleted = 1 WHERE id = ?")->execute([$id]);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getData()
    {
        try {
            $id = (int) ($_GET['id'] ?? 0);
            if (!$id) throw new Exception('Invalid payment ID.');

            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.client_id,
                    p.amount_paid,
                    p.payment_date,
                    u.firstname,
                    u.lastname
                FROM payments p
                JOIN clients c ON p.client_id = c.id
                JOIN users u ON c.user_id = u.id
                WHERE p.id = ? AND u.is_deleted = 0
            ");

            $stmt->execute([$id]);
            $payment = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$payment) {
                throw new Exception('Payment record not found.');
            }

            echo json_encode([
                'success' => true,
                'data' => $payment
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    private function listData()
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.amount_paid,
                    p.payment_date,
                    u.firstname,
                    u.lastname
                FROM payments p
                JOIN clients c ON p.client_id = c.id
                JOIN users u ON c.user_id = u.id
                WHERE u.is_deleted = 0
                ORDER BY p.date_paid DESC
            ");

            $stmt->execute();
            $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'data' => $payments
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

$handler = new PaymentHandler($pdo);
$handler->handleRequest();
