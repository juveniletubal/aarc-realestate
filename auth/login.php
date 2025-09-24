<?php
require_once "../classes/Database.php";
require_once "session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        // Use prepared statements
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND is_deleted = 0");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check password
        if ($user && password_verify($password, $user['password'])) {
            // Regenerate session ID
            session_regenerate_id(true);

            // Store minimal info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_time'] = time(); // optional: track session start


            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $person = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($person) {
                // Mark as active
                $stmt = $pdo->prepare("UPDATE users SET is_active = 1 WHERE id = :id");
                $stmt->execute(['id' => $_SESSION['user_id']]);

                if (!empty($person['image'])) {
                    $_SESSION['image'] = "../uploads/users/" . $person['image'];
                } else {
                    $_SESSION['image'] = "../assets/img/person/person-m-10.webp";
                }

                $_SESSION['fullname'] = $person['firstname'] . ' ' . $person['lastname'];
            } else {
                $_SESSION['image'] = "../assets/img/person/person-m-10.webp";
            }


            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../admin/");
                    break;
                case 'staff':
                    header("Location: ../staff/");
                    break;
                case 'agent':
                    header("Location: ../agent/");
                    break;
                default:
                    header("Location: ../client/");
                    break;
            }
            exit;
        } else {
            // Avoid detailed error messages
            $_SESSION['error'] = "Invalid username or password";
            header("Location: ../login");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Something went wrong, try again later.";
        header("Location: ../login");
        exit;
    }
}
