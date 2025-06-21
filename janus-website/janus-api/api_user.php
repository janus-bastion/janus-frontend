<?php
require_once '/usr/share/nginx/html/janus-api/auth_admin.php';

if (!isset($_GET['username'])) {
    http_response_code(400);
    echo 'Missing username parameter.';
    exit;
}

$targetUsername = $_GET['username'];

$stmt = $connexion->prepare("SELECT id, username, email, is_admin, created_at FROM users WHERE username = ?");
$stmt->bind_param("s", $targetUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo 'User not found.';
    exit;
}

$userData = $result->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($userData);

$connexion->close();

