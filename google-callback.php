<?php
session_start();

$config = require __DIR__ . "/config/google.php";
$client_id = $config['client_id'];
$client_secret = $config['client_secret'];
$redirect_uri = $config['redirect_uri'];

if (!isset($_GET['code'])) {
    die("No code returned from Google");
}

$code = $_GET['code'];

// Exchange code for access token
$token_url = "https://oauth2.googleapis.com/token";
$data = [
    "code" => $code,
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "redirect_uri" => $redirect_uri,
    "grant_type" => "authorization_code"
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/x-www-form-urlencoded",
        "method"  => "POST",
        "content" => http_build_query($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);
if (!$response) die("Error fetching token");

$token = json_decode($response, true);

// Fetch user info
$userinfo = file_get_contents("https://www.googleapis.com/oauth2/v3/userinfo?access_token=" . $token['access_token']);
$user = json_decode($userinfo, true);

// Save to session
$_SESSION['user'] = $user;

// Redirect to dashboard
header("Location: admin");
exit;
