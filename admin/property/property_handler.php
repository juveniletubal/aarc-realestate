<?php
require_once '../../classes/Database.php';

class PropertyHandler
{
    private $pdo;
    private $uploadDir = '../../uploads/';

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
                    $this->insertProperty();
                    break;
                case 'update':
                    $this->updateProperty();
                    break;
                case 'delete':
                    $this->deleteProperty();
                    break;
                case 'get':
                    $this->getProperty();
                    break;
                case 'list':
                    $this->listProperties();
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
        $required = ['title', 'lot', 'block', 'lot_area', 'price', 'location'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception(ucfirst($field) . ' is required');
            }
        }

        if (!is_numeric(str_replace(',', '', $data['price']))) {
            throw new Exception('Invalid price format');
        }
    }

    private function insertProperty()
    {
        $this->validateInput($_POST);

        $stmt = $this->pdo->prepare("
            INSERT INTO properties (title, lot, block, description, lot_area, price, location, property_type, status, images) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $images = $this->handleImageUpload();
        $price = (float) str_replace(',', '', $_POST['price']);

        // Store images as comma-separated string instead of JSON
        $imagesString = !empty($images) ? implode(',', $images) : '';

        $stmt->execute([
            $_POST['title'],
            $_POST['lot'],
            $_POST['block'],
            $_POST['description'],
            $_POST['lot_area'] ?? '',
            $price,
            $_POST['location'] ?? '',
            $_POST['property_type'],
            $_POST['status'],
            $imagesString
        ]);

        echo json_encode(['success' => true, 'id' => $this->pdo->lastInsertId()]);
    }

    private function updateProperty()
    {
        $id = (int) $_POST['id'];
        if (!$id) throw new Exception('Invalid property ID');

        $this->validateInput($_POST);

        // Get existing property
        $stmt = $this->pdo->prepare("SELECT images FROM properties WHERE id = ? AND is_deleted = 0");
        $stmt->execute([$id]);
        $existing = $stmt->fetch();

        if (!$existing) throw new Exception('Property not found');

        // Convert existing images from comma-separated to array
        $existingImages = !empty($existing['images']) ? explode(',', $existing['images']) : [];
        $newImages = $this->handleImageUpload($id, $existingImages);

        $stmt = $this->pdo->prepare("
            UPDATE properties 
            SET title = ?, lot = ?, block = ?, description = ?, lot_area = ?, price = ?, location = ?, property_type = ?, status = ?, images = ?
            WHERE id = ? AND is_deleted = 0
        ");

        $price = (float) str_replace(',', '', $_POST['price']);

        // Store images as comma-separated string
        $imagesString = !empty($newImages) ? implode(',', $newImages) : '';

        $stmt->execute([
            $_POST['title'],
            $_POST['lot'],
            $_POST['block'],
            $_POST['description'],
            $_POST['lot_area'] ?? '',
            $price,
            $_POST['location'] ?? '',
            $_POST['property_type'],
            $_POST['status'],
            $imagesString,
            $id
        ]);

        echo json_encode(['success' => true]);
    }

    private function deleteProperty()
    {
        $id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
        if (!$id) throw new Exception('Invalid property ID');

        // Get images before soft delete
        $stmt = $this->pdo->prepare("SELECT images FROM properties WHERE id = ? AND is_deleted = 0");
        $stmt->execute([$id]);
        $property = $stmt->fetch();

        if (!$property) throw new Exception('Property not found');

        // Soft delete
        $stmt = $this->pdo->prepare("UPDATE properties SET is_deleted = 1, images = '' WHERE id = ?");
        $stmt->execute([$id]);

        // Delete images from server
        if (!empty($property['images'])) {
            $images = explode(',', $property['images']);
            foreach ($images as $image) {
                $imagePath = $this->uploadDir . trim($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        echo json_encode(['success' => true]);
    }

    private function getProperty()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if (!$id) throw new Exception('Invalid property ID');

        $stmt = $this->pdo->prepare("SELECT * FROM properties WHERE id = ? AND is_deleted = 0");
        $stmt->execute([$id]);
        $property = $stmt->fetch();

        if (!$property) throw new Exception('Property not found');

        // Convert comma-separated images to array
        $property['images'] = !empty($property['images']) ? explode(',', $property['images']) : [];

        echo json_encode(['success' => true, 'data' => $property]);
    }

    private function listProperties()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM properties WHERE is_deleted = 0 ORDER BY created DESC");
        $stmt->execute();
        $properties = $stmt->fetchAll();

        foreach ($properties as &$property) {
            $property['images'] = !empty($property['images']) ? explode(',', $property['images']) : [];
        }

        echo json_encode(['success' => true, 'data' => $properties]);
    }

    private function handleImageUpload($propertyId = null, $existingImages = [])
    {
        $images = $existingImages;

        // Handle removed images
        if (isset($_POST['removed_images'])) {
            $removedImages = json_decode($_POST['removed_images'], true) ?: [];
            foreach ($removedImages as $removedImage) {
                $imagePath = $this->uploadDir . $removedImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $images = array_filter($images, function ($img) use ($removedImage) {
                    return $img !== $removedImage;
                });
            }
        }

        // Handle new uploads
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $key => $name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $image = $this->processImage($_FILES['images']['tmp_name'][$key], $name);
                    if ($image) {
                        $images[] = $image;
                    }
                }
            }
        }

        return array_values($images); // Re-index array
    }

    private function processImage($tmpName, $originalName)
    {
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($tmpName);

        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception('Invalid image type. Only JPEG, PNG, GIF, and WebP allowed.');
        }

        // Generate unique filename
        $extension = 'webp';
        $filename = uniqid('prop_', true) . '.' . $extension;
        $filepath = $this->uploadDir . $filename;

        // Create image from source
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

        if (!$image) {
            throw new Exception('Failed to process image');
        }

        // Resize if too large (max 1200px width)
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > 1200) {
            $newWidth = 1200;
            $newHeight = ($height * $newWidth) / $width;

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG/GIF
            if ($fileType === 'image/png' || $fileType === 'image/gif') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
            }

            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resizedImage;
        }

        // Save as WebP
        if (imagewebp($image, $filepath, 80)) {
            imagedestroy($image);
            return $filename;
        } else {
            imagedestroy($image);
            throw new Exception('Failed to save image');
        }
    }
}

// Initialize handler
$handler = new PropertyHandler($pdo);
$handler->handleRequest();
