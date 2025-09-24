<?php
require_once '../../classes/Database.php';

class AgentHandler
{
    private $pdo;
    private $uploadDir = '../../uploads/agents/';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function handleRequest()
    {
        header('Content-Type: application/json');

        $action = $_POST['action'] ?? $_GET['action'] ?? '';

        try {
            switch ($action) {
                case 'insert':
                    $this->insertAgent();
                    break;
                case 'update':
                    $this->updateAgent();
                    break;
                case 'delete':
                    $this->deleteAgent();
                    break;
                case 'get':
                    $this->getAgent();
                    break;
                case 'list':
                    $this->listAgents();
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
        $required = ['firstname', 'lastname', 'email', 'phone'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception(ucfirst($field) . ' is required');
            }
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        $sql = "SELECT id FROM agents WHERE email = ? AND is_deleted = 0";
        if ($id) $sql .= " AND id != ?";
        $stmt = $this->pdo->prepare($sql);

        $params = [$data['email']];
        if ($id) $params[] = $id;

        $stmt->execute($params);
        if ($stmt->fetch()) {
            throw new Exception('Email already exists. Please use another email.');
        }
    }

    private function insertAgent()
    {
        try {
            $this->validateInput($_POST);

            $userId = $this->createUserAccount($_POST);
            $image = $this->handleImageUpload();

            $stmt = $this->pdo->prepare("
                INSERT INTO agents (firstname, lastname, email, phone, facebook_link, license_number, percent, position, upline_id, profile_image, user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['facebook_link'] ?? '',
                $_POST['license_number'] ?? '',
                $_POST['percent'],
                $_POST['position'],
                $_POST['upline'] ?? '',
                $image,
                $userId
            ]);

            echo json_encode(['success' => true, 'id' => $this->pdo->lastInsertId(), 'user_id' => $userId]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function updateAgent()
    {
        try {
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) throw new Exception('Invalid agent ID');

            $this->validateInput($_POST, $id);

            $stmt = $this->pdo->prepare("SELECT profile_image, user_id FROM agents WHERE id = ? AND is_deleted = 0");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if (!$existing) throw new Exception('Agent not found');

            // Update or create user account
            $userId = !empty($existing['user_id'])
                ? $this->updateUserAccount($existing['user_id'], $_POST)
                : $this->createUserAccount($_POST);

            $newImage = $this->handleImageUpload($existing['profile_image']);

            $stmt = $this->pdo->prepare("
                UPDATE agents 
                SET firstname = ?, lastname = ?, email = ?, phone = ?, facebook_link = ?, license_number = ?, percent = ?, position = ?, upline_id = ?, profile_image = ?, user_id = ?
                WHERE id = ? AND is_deleted = 0
            ");

            $stmt->execute([
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['facebook_link'] ?? '',
                $_POST['license_number'] ?? '',
                $_POST['percent'],
                $_POST['position'],
                $_POST['upline'] ?? '',
                $newImage,
                $userId,
                $id
            ]);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function deleteAgent()
    {
        try {
            $id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
            if (!$id) throw new Exception('Invalid agent ID');

            $stmt = $this->pdo->prepare("SELECT profile_image FROM agents WHERE id = ? AND is_deleted = 0");
            $stmt->execute([$id]);
            $agent = $stmt->fetch();
            if (!$agent) throw new Exception('Agent not found');

            $stmt = $this->pdo->prepare("UPDATE agents SET is_deleted = 1, profile_image = '' WHERE id = ?");
            $stmt->execute([$id]);

            if (!empty($agent['profile_image'])) {
                $imagePath = $this->uploadDir . $agent['profile_image'];
                if (file_exists($imagePath)) unlink($imagePath);
            }

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getAgent()
    {
        try {
            $id = (int) ($_GET['id'] ?? 0);
            if (!$id) throw new Exception('Invalid agent ID');

            $stmt = $this->pdo->prepare("
                SELECT a.*, u.username, u.role 
                FROM agents a
                LEFT JOIN users u ON a.user_id = u.id
                WHERE a.id = ? AND a.is_deleted = 0
            ");
            $stmt->execute([$id]);
            $agent = $stmt->fetch();
            if (!$agent) throw new Exception('Agent not found');

            echo json_encode(['success' => true, 'data' => $agent]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function listAgents()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agents WHERE is_deleted = 0 ORDER BY created DESC");
        $stmt->execute();
        $agents = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $agents]);
    }

    private function handleImageUpload($existingImage = '')
    {
        try {
            if (!empty($_FILES['image']['name'])) {
                if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $newImage = $this->processImage($_FILES['image']['tmp_name'], $_FILES['image']['name']);

                    if (!empty($existingImage)) {
                        $oldPath = $this->uploadDir . $existingImage;
                        if (file_exists($oldPath)) unlink($oldPath);
                    }

                    return $newImage;
                } else {
                    throw new Exception('Image upload error code: ' . $_FILES['image']['error']);
                }
            }
            return $existingImage;
        } catch (Exception $e) {
            throw new Exception('Image upload failed: ' . $e->getMessage());
        }
    }

    private function processImage($tmpName, $originalName)
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($tmpName);
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception('Invalid image type. Only JPEG, PNG, GIF, WebP allowed.');
        }

        $lastname = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($_POST['lastname']));
        $filename = $lastname . '_' . substr(bin2hex(random_bytes(4)), 0, 8) . '.webp';
        $filepath = $this->uploadDir . $filename;

        switch ($fileType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($tmpName);
                break;
            case 'image/png':
                $image = imagecreatefrompng($tmpName);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($tmpName);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($tmpName);
                break;
            default:
                throw new Exception('Unsupported image type');
        }

        if (!$image) throw new Exception('Failed to process image');

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > 1200) {
            $newWidth = 1200;
            $newHeight = ($height * $newWidth) / $width;
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resizedImage;
        }

        if (imagewebp($image, $filepath, 80)) {
            imagedestroy($image);
            return $filename;
        } else {
            imagedestroy($image);
            throw new Exception('Failed to save image');
        }
    }

    private function createUserAccount($data)
    {
        if (empty($data['username'])) throw new Exception('Username is required');
        $password = password_hash($data['password'] ?? '123456', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$data['username'], $password, 'agent']);
        return (int)$this->pdo->lastInsertId();
    }

    private function updateUserAccount($userId, $data)
    {
        $sql = "UPDATE users SET username = ?, role = ?";
        $params = [$data['username'], 'agent'];

        if (!empty($data['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = ?";
        $params[] = $userId;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $userId;
    }
}

$handler = new AgentHandler($pdo);
$handler->handleRequest();
