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
        $required = ['firstname', 'lastname', 'contact', 'property_id', 'payment_terms', 'total_price'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception(ucfirst($field) . ' is required');
            }
        }

        // if (!empty($data['username'])) {
        //     // Only check if username is new or modified
        //     $sql = "SELECT id FROM users WHERE username = ? AND role = 'client'";
        //     if ($id) $sql .= " AND id != ?";
        //     $stmt = $this->pdo->prepare($sql);
        //     $stmt->execute($id ? [$data['username'], $id] : [$data['username']]);

        //     if ($stmt->fetch()) {
        //         throw new Exception('Username already exists. Please use another username.');
        //     }
        // }
    }

    private function insertData()
    {
        try {
            $this->validateInput($_POST);

            $userId = $this->createUserAccount($_POST);

            $stmt = $this->pdo->prepare("
                INSERT INTO clients (user_id, assigned_agent, assigned_staff, property_id, payment_terms, total_price, balance, penalty, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");

            $assignedAgent = $_POST['assigned_agent'] ?? null;

            $assignedStaff = $_POST['assigned_staff'] ?? null;

            $stmt->execute([
                $userId,
                $assignedAgent,
                $assignedStaff,
                $_POST['property_id'],
                $_POST['payment_terms'],
                $_POST['total_price'],
                $_POST['balance'] ?? 0,
                $_POST['penalty'] ?? 0
            ]);

            echo json_encode(['success' => true, 'id' => $this->pdo->lastInsertId(), 'user_id' => $userId]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function updateData()
    {
        try {
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) throw new Exception('Invalid client ID');

            $this->validateInput($_POST, $id);

            // Get existing client
            $stmt = $this->pdo->prepare("SELECT user_id FROM clients WHERE id = ?");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if (!$existing) throw new Exception('Client not found');

            // Update user account
            $userId = $this->updateUserAccount($existing['user_id'], $_POST);

            $assignedAgent = $_POST['assigned_agent'] ?? ($_SESSION['user_id'] ?? null);

            $assignedStaff = $_POST['assigned_staff'] ?? null;

            $stmt = $this->pdo->prepare("
                UPDATE clients
                SET assigned_agent = ?, assigned_staff = ?, property_id = ?, payment_terms = ?, total_price = ?, balance = ?, penalty = ?, updated_at = NOW()
                WHERE id = ?
            ");

            $stmt->execute([
                $assignedAgent,
                $assignedStaff,
                $_POST['property_id'],
                $_POST['payment_terms'],
                $_POST['total_price'],
                $_POST['balance'] ?? 0,
                $_POST['penalty'] ?? 0,
                $id
            ]);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function deleteData()
    {
        try {
            $id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
            if (!$id) throw new Exception('Invalid client ID');

            // Soft delete client + user
            $stmt = $this->pdo->prepare("SELECT user_id FROM clients WHERE id = ?");
            $stmt->execute([$id]);
            $client = $stmt->fetch();
            if (!$client) throw new Exception('Client not found');

            $this->pdo->prepare("UPDATE clients SET is_deleted = 1 WHERE id = ?")->execute([$id]);
            $this->pdo->prepare("UPDATE users SET is_deleted = 1 WHERE id = ?")->execute([$client['user_id']]);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getData()
    {
        try {
            $id = (int) ($_GET['id'] ?? 0);
            if (!$id) throw new Exception('Invalid client ID');

            $stmt = $this->pdo->prepare("
                SELECT c.*, u.firstname, u.lastname, u.contact, u.address, u.username, u.role
                FROM clients c
                JOIN users u ON c.user_id = u.id
                WHERE c.id = ? AND u.is_deleted = 0
            ");
            $stmt->execute([$id]);
            $client = $stmt->fetch();
            if (!$client) throw new Exception('Client not found');

            echo json_encode(['success' => true, 'data' => $client]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function listData()
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.firstname, u.lastname, u.contact, u.address, u.username
            FROM clients c
            JOIN users u ON c.user_id = u.id
            WHERE c.is_deleted = 0
            ORDER BY c.created_at DESC
        ");
        $stmt->execute();
        $clients = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $clients]);
    }

    private function createUserAccount($data)
    {
        if (empty($data['username'])) throw new Exception('Username is required');
        if (empty($data['password'])) throw new Exception('Password is required');

        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("
            INSERT INTO users (firstname, lastname, contact, address, username, password, role)
            VALUES (?, ?, ?, ?, ?, ?, 'client')
        ");
        $stmt->execute([
            $data['firstname'],
            $data['lastname'],
            $data['contact'],
            $data['address'],
            $data['username'],
            $password
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    private function updateUserAccount($userId, $data)
    {
        $sql = "UPDATE users SET firstname = ?, lastname = ?, contact = ?, address = ?, username = ?";
        $params = [
            $data['firstname'],
            $data['lastname'],
            $data['contact'],
            $data['address'],
            $data['username']
        ];

        if (!empty($data['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = ? AND role = 'client'";
        $params[] = $userId;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $userId;
    }
}

$handler = new ClientHandler($pdo);
$handler->handleRequest();
