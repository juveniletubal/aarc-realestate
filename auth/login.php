<?php
require_once "../classes/Database.php";
require_once "session.php";

$env = parse_ini_file(__DIR__ . '/.env');
$secretKey = $env['RECAPTCHA_SECRET_KEY'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($_SESSION['failed_attempts'] >= 3) {
        file_put_contents(__DIR__ . '/recaptcha_log.txt', "CAPTCHA Triggered\n", FILE_APPEND);

        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
        if (empty($recaptchaResponse)) {
            $_SESSION['error'] = "Please complete the reCAPTCHA challenge.";
            header("Location: ../login");
            exit;
        }

        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseData = json_decode($verify);

        file_put_contents(
            __DIR__ . '/recaptcha_log.txt',
            date('Y-m-d H:i:s') . "\n" .
                "Response raw: " . $verify . "\n" .
                "Decoded: " . print_r($responseData, true) . "\n" .
                "Score: " . ($responseData->score ?? 'N/A') . "\n\n",
            FILE_APPEND
        );

        if (!$responseData->success || $responseData->score < 0.5) {
            $_SESSION['error'] = "Suspicious activity detected. Please try again.";
            header("Location: ../login");
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND is_deleted = 0");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_time'] = time();


            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $person = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($person) {
                $stmt = $pdo->prepare("UPDATE users SET is_active = 1 WHERE id = :id");
                $stmt->execute(['id' => $_SESSION['user_id']]);

                if (!empty($person['image'])) {
                    $_SESSION['image'] = "../uploads/users/" . $person['image'];
                } else {
                    $_SESSION['image'] = "../assets/img/person/person-m-10.webp";
                }

                $_SESSION['fullname'] = $person['firstname'] . ' ' . $person['lastname'];

                if ($person['role'] == 'admin') {
                    $role_type = 'Admin';
                } elseif ($person['role'] == 'staff') {
                    $role_type = 'Staff';
                } elseif ($person['role'] == 'agent') {
                    $role_type = 'Agent';
                } else {
                    $role_type = 'Client';
                }

                $_SESSION['welcome_message'] = "Welcome " . $_SESSION['fullname'] . " (" . $role_type . ")";
            } else {
                $_SESSION['image'] = "../assets/img/person/person-m-10.webp";
            }

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
