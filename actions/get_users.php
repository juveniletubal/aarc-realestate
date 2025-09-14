<?php
require "../classes/Database.php";

if (!isset($_POST['id'])) {
    echo json_encode(["error" => "No ID provided"]);
    exit;
}

$id = (int) $_POST['id'];

$stmt = $pdo->prepare("SELECT id, name, email, role FROM users_tbl WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode($user);
} else {
    echo json_encode(["error" => "User not found"]);
}
