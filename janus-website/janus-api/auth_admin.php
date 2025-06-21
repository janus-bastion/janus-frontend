<?php
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic realm="Access restricted"');
    http_response_code(401);
    echo 'Authentication required.';
    exit;
}

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

$stmt = $connexion->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo 'User not found.';
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    http_response_code(403);
    echo 'Incorrect password.';
    exit;
}

if ((int)$user['is_admin'] !== 1) {
    http_response_code(403);
    echo "Access denied: you're not an administrator.";
    exit;
}


