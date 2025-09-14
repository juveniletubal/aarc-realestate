<?php
require "../classes/Database.php";

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case "insert":
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['role'])) {
                $stmt = $pdo->prepare("INSERT INTO users_tbl (name, email, role, created) 
                                       VALUES (?, ?, ?, NOW())");
                $stmt->execute([
                    trim($_POST['name']),
                    trim($_POST['email']),
                    trim($_POST['role'])
                ]);
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            }
            break;

        case "update":
            if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['email'])) {
                $stmt = $pdo->prepare("UPDATE users_tbl SET name=?, email=?, role=? WHERE id=?");
                $stmt->execute([
                    trim($_POST['name']),
                    trim($_POST['email']),
                    trim($_POST['role']),
                    intval($_POST['id'])
                ]);
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid update data"]);
            }
            break;

        case "delete":
            if (!empty($_POST['id'])) {
                $stmt = $pdo->prepare("DELETE FROM users_tbl WHERE id=?");
                $stmt->execute([intval($_POST['id'])]);
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Missing ID"]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Invalid action"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
