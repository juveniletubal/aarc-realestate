<?php
// Force session to expire on browser close
ini_set('session.cookie_lifetime', 0);

// Secure session start
session_start([
    'cookie_lifetime' => 0,
    'cookie_secure' => false, // set true if using HTTPS
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
]);


// Uncomment this to add auto logout

// require_once __DIR__ . '/../classes/Database.php';

// // Optional: auto logout after inactivity (15 minutes)
// $timeout = 900; // 15 minutes

// if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
//     // If user is agent, mark offline
//     if (isset($_SESSION['role']) && $_SESSION['role'] === 'agent') {
//         $stmt = $pdo->prepare("UPDATE agents SET is_active = 0 WHERE userid = :id");
//         $stmt->execute(['id' => $_SESSION['user_id']]);
//     }

//     $_SESSION = [];
//     session_unset();
//     session_destroy();
//     header("Location: ../login?timeout=1");
//     exit;
// }

// // Update last activity time
// if (isset($_SESSION['user_id'])) {
//     $_SESSION['login_time'] = time();
// }
