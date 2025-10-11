<?php
require_once '../../classes/Database.php';

class CommissionHandler
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
        $required = ['director', 'director_percent', 'term'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception(ucfirst($field) . ' is required');
            }
        }
    }

    // private function insertData()
    // {
    //     try {
    //         $this->validateInput($_POST);

    //         $client_id = $_POST['clientId'] ?? null;
    //         if (!$client_id) {
    //             throw new Exception("Client ID is required.");
    //         }

    //         $director_id = $_POST['director'] ?? null;
    //         $director_percent = $_POST['director_percent'] ?? 0;

    //         $manager_id = $_POST['manager'] ?? null;
    //         $manager_percent = $_POST['manager_percent'] ?? 0;

    //         $downline_id = $_POST['downline'] ?? null;
    //         $downline_percent = $_POST['downline_percent'] ?? 0;

    //         $term = $_POST['term'];
    //         $com_ref = uniqid("com_");

    //         $stmt = $this->pdo->prepare("
    //             INSERT INTO commissions (com_ref, user_id, role, percent, term, created_at, updated_at)
    //             VALUES (?, ?, ?, ?, ?, NOW(), NOW())
    //         ");

    //         if (!empty($director_id)) {
    //             $stmt->execute([$com_ref, $director_id, 'director', $director_percent, $term]);
    //         }

    //         if (!empty($manager_id)) {
    //             $stmt->execute([$com_ref, $manager_id, 'manager', $manager_percent, $term]);
    //         }

    //         if (!empty($downline_id)) {
    //             $stmt->execute([$com_ref, $downline_id, 'downline', $downline_percent, $term]);
    //         }

    //         $updateClient = $this->pdo->prepare("
    //                 UPDATE clients 
    //                     SET assigned_agent = ? WHERE id = ?
    //                 ");
    //         $updateClient->execute([$com_ref, $client_id]);

    //         echo json_encode([
    //             'success' => true,
    //             'com_ref' => $com_ref,
    //             'message' => 'Commission(s) inserted successfully.'
    //         ]);
    //     } catch (Exception $e) {
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    private function updateData()
    {
        try {
            $client_id = $_POST['clientId'] ?? null;
            if (!$client_id) {
                throw new Exception("Client ID is required.");
            }

            $this->validateInput($_POST, $client_id);

            // Get existing commission reference
            $stmt = $this->pdo->prepare("SELECT assigned_agent FROM clients WHERE id = ?");
            $stmt->execute([$client_id]);
            $client = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$client) {
                throw new Exception("Client not found.");
            }

            $com_ref = $client['assigned_agent'] ?: uniqid("com_");

            $term = $_POST['term'] ?? null;

            // Roles and percents
            $roles = [
                'director' => [
                    'user_id' => $_POST['director'] ?? null,
                    'percent' => $_POST['director_percent'] ?? 0,
                ],
                'manager' => [
                    'user_id' => $_POST['manager'] ?? null,
                    'percent' => $_POST['manager_percent'] ?? 0,
                ],
                'downline' => [
                    'user_id' => $_POST['downline'] ?? null,
                    'percent' => $_POST['downline_percent'] ?? 0,
                ],
            ];

            $this->pdo->beginTransaction();

            foreach ($roles as $role => $data) {
                $user_id = $data['user_id'];
                $percent = $data['percent'];

                // Check if this role already exists
                $checkStmt = $this->pdo->prepare("
                SELECT id FROM commissions 
                WHERE com_ref = ? AND role = ?
            ");
                $checkStmt->execute([$com_ref, $role]);
                $existing = $checkStmt->fetchColumn();

                if ($user_id) {
                    if ($existing) {
                        // 🔹 Update existing role
                        $updateStmt = $this->pdo->prepare("
                        UPDATE commissions 
                        SET user_id = ?, percent = ?, term = ?, updated_at = NOW()
                        WHERE com_ref = ? AND role = ?
                    ");
                        $updateStmt->execute([$user_id, $percent, $term, $com_ref, $role]);
                    } else {
                        // 🔹 Insert new role
                        $insertStmt = $this->pdo->prepare("
                        INSERT INTO commissions (com_ref, user_id, role, percent, term, created_at, updated_at)
                        VALUES (?, ?, ?, ?, ?, NOW(), NOW())
                    ");
                        $insertStmt->execute([$com_ref, $user_id, $role, $percent, $term]);
                    }
                } else {
                    // 🔹 If role was removed, delete it
                    if ($existing) {
                        $deleteStmt = $this->pdo->prepare("
                        DELETE FROM commissions 
                        WHERE com_ref = ? AND role = ?
                    ");
                        $deleteStmt->execute([$com_ref, $role]);
                    }
                }
            }

            // Always make sure client has correct assigned com_ref
            $updateClient = $this->pdo->prepare("
            UPDATE clients 
            SET assigned_agent = ? 
            WHERE id = ?
        ");
            $updateClient->execute([$com_ref, $client_id]);

            $this->pdo->commit();

            echo json_encode([
                'success' => true,
                'com_ref' => $com_ref,
                'message' => 'Commissions updated successfully.'
            ]);
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    private function deleteData()
    {
        try {
            $client_id = $_POST['clientId'] ?? null;
            $com_ref = $_POST['com_ref'] ?? null;

            if (empty($client_id) || empty($com_ref)) {
                throw new Exception("Client ID and Commission Reference are required.");
            }

            $this->pdo->beginTransaction();

            // Unassign the agent from the client
            $stmt1 = $this->pdo->prepare("UPDATE clients SET assigned_agent = NULL WHERE id = ?");
            $stmt1->execute([$client_id]);

            // Delete all commission records linked to this com_ref
            $stmt2 = $this->pdo->prepare("DELETE FROM commissions WHERE com_ref = ?");
            $stmt2->execute([$com_ref]);

            $this->pdo->commit();

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // private function getData()
    // {
    //     try {
    //         $id = (int) ($_GET['id'] ?? 0);
    //         if (!$id) throw new Exception('Invalid client ID');

    //         $stmt = $this->pdo->prepare("
    //         SELECT 
    //             c.id AS client_id,
    //             c.assigned_agent,
    //             cm.com_ref,
    //             cm.user_id,
    //             u.firstname,
    //             u.lastname,
    //             cm.role,
    //             cm.percent,
    //             cm.term
    //         FROM clients c
    //         JOIN commissions cm ON c.assigned_agent = cm.com_ref
    //         JOIN users u ON cm.user_id = u.id
    //         WHERE c.id = ? 
    //           AND cm.is_deleted = 0 
    //           AND c.is_deleted = 0
    //     ");
    //         $stmt->execute([$id]);
    //         $commissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         if (!$commissions) throw new Exception('Client not found or no commissions');

    //         echo json_encode(['success' => true, 'data' => $commissions]);
    //     } catch (Exception $e) {
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }


    // private function listData()
    // {
    //     $stmt = $this->pdo->prepare("
    //         SELECT c.*, u.firstname, u.lastname, u.contact, u.address, u.username
    //         FROM clients c
    //         JOIN users u ON c.user_id = u.id
    //         WHERE c.is_deleted = 0
    //         ORDER BY c.created_at DESC
    //     ");
    //     $stmt->execute();
    //     $clients = $stmt->fetchAll();

    //     echo json_encode(['success' => true, 'data' => $clients]);
    // }
}

$handler = new CommissionHandler($pdo);
$handler->handleRequest();
