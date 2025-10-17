<?php
require_once '../../classes/Database.php';

class ClientHandler
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
                default:
                    throw new Exception('Invalid action');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function validateInput($data)
    {
        $required = ['client_id', 'property_id', 'payment_terms'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception(ucfirst($field) . ' is required');
            }
        }
    }

    private function insertData()
    {
        try {
            $this->validateInput($_POST);

            $check = $this->pdo->prepare("
                SELECT COUNT(*) FROM clients 
                WHERE user_id = ? AND property_id = ?
            ");
            $check->execute([$_POST['client_id'], $_POST['property_id']]);
            $exists = $check->fetchColumn();

            if ($exists > 0) {
                throw new Exception("This client is already assigned to the selected property.");
            }

            $stmt = $this->pdo->prepare("SELECT status FROM properties WHERE id = ?");
            $stmt->execute([$_POST['property_id']]);
            $property = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$property) {
                throw new Exception("Invalid property selected.");
            }

            if ($property['status'] === 'sold') {
                throw new Exception("This property has already been sold. Please select another one.");
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO clients (user_id, assigned_staff, property_id, payment_terms, total_price, balance, penalty, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");

            $stmt->execute([
                $_POST['client_id'],
                $_POST['assigned_staff'],
                $_POST['property_id'],
                $_POST['payment_terms'],
                $_POST['total_price'],
                $_POST['balance'] ?? 0,
                $_POST['penalty'] ?? 0
            ]);

            $stmt = $this->pdo->prepare("
                UPDATE properties
                SET status = 'reserved'
                WHERE id = ?
            ");
            $stmt->execute([$_POST['property_id']]);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

$handler = new ClientHandler($pdo);
$handler->handleRequest();
