<?php
// includes/user_update/update_profile.php
session_start();
require_once '../../classes/Database.php';
header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? 0;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT image FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    $existingImage = $existing['image'] ?? '';

    // Collect fields
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $facebook_link = $_POST['facebook_link'];
    $username = $_POST['username'];
    $password = $_POST['password'] ?? '';

    // Handle image upload
    $uploadDir = '../../uploads/users/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    function handleImageUpload($uploadDir, $existingImage, $lastname)
    {
        if (!empty($_FILES['image']['name'])) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Upload error: ' . $_FILES['image']['error']);
            }

            $tmp = $_FILES['image']['tmp_name'];
            $mime = mime_content_type($tmp);
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($mime, $allowed)) {
                throw new Exception('Invalid image type.');
            }

            $lastnameSafe = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($lastname));
            $filename = $lastnameSafe . '_' . substr(bin2hex(random_bytes(4)), 0, 8) . '.webp';
            $path = $uploadDir . $filename;

            switch ($mime) {
                case 'image/jpeg':
                    $img = imagecreatefromjpeg($tmp);
                    break;
                case 'image/png':
                    $img = imagecreatefrompng($tmp);
                    break;
                case 'image/gif':
                    $img = imagecreatefromgif($tmp);
                    break;
                case 'image/webp':
                    $img = imagecreatefromwebp($tmp);
                    break;
                default:
                    throw new Exception('Unsupported image type');
            }

            if (!$img) throw new Exception('Failed to process image');
            imagewebp($img, $path, 80);
            imagedestroy($img);

            if ($existingImage && file_exists($uploadDir . $existingImage)) {
                unlink($uploadDir . $existingImage);
            }

            return $filename;
        }
        return $existingImage;
    }

    $imageFilename = handleImageUpload($uploadDir, $existingImage, $lastname);

    // Prepare SQL
    $sql = "UPDATE users SET firstname=?, lastname=?, contact=?, email=?, address=?, facebook_link=?, username=?";
    $params = [$firstname, $lastname, $contact, $email, $address, $facebook_link, $username];

    if (!empty($password)) {
        $sql .= ", password=?";
        $params[] = password_hash($password, PASSWORD_BCRYPT);
    }

    $sql .= ", image=? WHERE id=?";
    $params[] = $imageFilename;
    $params[] = $userId;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $_SESSION['image'] = "../uploads/users/" . $imageFilename;
    $_SESSION['fullname'] = $firstname . ' ' . $lastname;

    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
