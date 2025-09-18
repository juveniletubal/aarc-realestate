<?php
header('Content-Type: application/json');
require_once "../../classes/Database.php";

// Security: Validate session/authentication here
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(["status" => "error", "message" => "Unauthorized"]);
//     exit;
// }

$uploadDir = "../../uploads";
$tmpDir = "../../uploads/tmp";

// Ensure directories exist
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
if (!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

// Debug logging
error_log("POST data: " . print_r($_POST, true));

// Input validation and sanitization
$action = $_POST['action'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$lot_area = $_POST['lot_area'] ?? '';
$price = $_POST['price'] ?? '';
$location = $_POST['location'] ?? '';
$property_type = $_POST['property_type'] ?? '';

$uploaded_files = !empty($_POST['uploaded_files']) ?
    array_filter(array_map('basename', explode(",", $_POST['uploaded_files']))) : [];
$original_images = !empty($_POST['original_images']) ?
    array_filter(array_map('basename', explode(",", $_POST['original_images']))) : [];

error_log("Uploaded files: " . print_r($uploaded_files, true));
error_log("Action: " . $action);

try {
    switch ($action) {
        case "insert":
            if (empty($title) || empty($description) || empty($price) || empty($property_type)) {
                throw new Exception("Required fields are missing");
            }

            $stmt = $pdo->prepare("INSERT INTO properties (title, description, lot_area, price, location, property_type, images, created) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$title, $description, $lot_area, $price, $location, $property_type, implode(",", $uploaded_files)]);

            // Move files from tmp to final location
            moveFilesToFinal($uploaded_files, $tmpDir, $uploadDir);
            break;

        case "update":
            $property_id = filter_input(INPUT_POST, 'property_id', FILTER_VALIDATE_INT);
            if (!$property_id) {
                throw new Exception("Invalid property ID");
            }

            if (empty($title) || empty($description) || empty($price) || empty($property_type)) {
                throw new Exception("Required fields are missing");
            }

            // Get current images from database
            $stmt = $pdo->prepare("SELECT images FROM properties WHERE id = ? AND is_deleted = 0");
            $stmt->execute([$property_id]);
            $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$currentData) {
                throw new Exception("Property not found");
            }

            $currentImages = !empty($currentData['images']) ? explode(",", $currentData['images']) : [];

            // Determine which images to remove
            $imagesToRemove = array_diff($currentImages, $uploaded_files);

            // Remove deleted images from server
            foreach ($imagesToRemove as $img) {
                $imgPath = $uploadDir . basename($img);
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
            }

            // Move new files from tmp to final
            $newFiles = array_diff($uploaded_files, $original_images);
            moveFilesToFinal($newFiles, $tmpDir, $uploadDir);

            // Update database
            $stmt = $pdo->prepare("UPDATE properties SET title=?, description=?, lot_area=?, price=?, location=?, property_type=?, images=?, updated=NOW() WHERE id=?");
            $stmt->execute([$title, $description, $lot_area, $price, $location, $property_type, implode(",", $uploaded_files), $property_id]);
            break;

        case "delete":
            $property_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (!$property_id) {
                throw new Exception("Invalid property ID");
            }

            // Soft delete - just mark as deleted
            $stmt = $pdo->prepare("UPDATE properties SET is_deleted = 1, updated = NOW() WHERE id = ?");
            $stmt->execute([$property_id]);

            // Optionally clean up images immediately or leave for scheduled cleanup
            // cleanupPropertyImages($property_id, $pdo, $uploadDir);
            break;

        default:
            throw new Exception("Invalid action");
    }

    // Clean up any remaining temp files
    cleanupTempFiles($tmpDir);

    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    // Log error for debugging
    error_log("Property CRUD Error: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

function moveFilesToFinal($files, $tmpDir, $uploadDir)
{
    error_log("Moving files to final: " . print_r($files, true));

    foreach ($files as $file) {
        $file = basename($file); // Security: prevent path traversal
        $tmpPath = $tmpDir . $file;
        $finalPath = $uploadDir . $file;

        error_log("Trying to move: $tmpPath to $finalPath");

        if (file_exists($tmpPath)) {
            if (rename($tmpPath, $finalPath)) {
                error_log("Successfully moved: $file");
            } else {
                error_log("Failed to move: $file");
                throw new Exception("Failed to move file: " . $file);
            }
        } else {
            error_log("File not found in tmp: $tmpPath");
            // Don't throw error for missing files, might be existing files
        }
    }
}

function cleanupTempFiles($tmpDir)
{
    $files = glob($tmpDir . "*");
    $cutoff = time() - 3600; // 1 hour old

    foreach ($files as $file) {
        if (is_file($file) && filemtime($file) < $cutoff) {
            unlink($file);
        }
    }
}

function cleanupPropertyImages($propertyId, $pdo, $uploadDir)
{
    $stmt = $pdo->prepare("SELECT images FROM properties WHERE id = ?");
    $stmt->execute([$propertyId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data && !empty($data['images'])) {
        $images = explode(",", $data['images']);
        foreach ($images as $img) {
            $imgPath = $uploadDir . basename($img);
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
    }
}
