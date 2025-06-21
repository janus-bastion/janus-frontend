<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "You must be logged in to add a remote connection.";
    header("Location: /home");
    exit;
}

$username = $_SESSION['user'];
$query = "SELECT id FROM users WHERE username = ?";
if ($stmt = mysqli_prepare($connexion, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (empty($user_id)) {
        $_SESSION['error'] = "User not found in the database.";
        header("Location: /home");
        exit;
    }
} else {
    $_SESSION['error'] = "Request error : " . mysqli_error($connexion);
    header("Location: /home");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connection_name = mysqli_real_escape_string($connexion, trim($_POST['connection_name']));
    $protocol = mysqli_real_escape_string($connexion, $_POST['protocol']);
    $ip_address = mysqli_real_escape_string($connexion, trim($_POST['ip_address']));
    $port = !empty($_POST['port']) ? (int)$_POST['port'] : null;
    $username_conn = mysqli_real_escape_string($connexion, trim($_POST['username']));
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if (empty($port)) {
        switch ($protocol) {
            case 'ssh': $port = 22; break;
            case 'vnc': $port = 5900; break;
            case 'rdp': $port = 3389; break;
        }
    }

    $check_sql = "SELECT id FROM remote_connections WHERE user_id = ? AND name = ?";
    $check_stmt = mysqli_prepare($connexion, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "is", $user_id, $connection_name);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        $_SESSION['error'] = "A connection with this name already exists.";
        mysqli_stmt_close($check_stmt);
        header('Location: /newconnect');
        exit;
    }
    mysqli_stmt_close($check_stmt);

    $sql = "INSERT INTO remote_connections (user_id, name, protocol, host, port, username, password)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connexion, $sql)) {
        mysqli_stmt_bind_param($stmt, "isssiss", $user_id, $connection_name, $protocol, $ip_address, $port, $username_conn, $password);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Connection successfully created!";
            header('Location: /dashboard');
            exit;
        } else {
            $_SESSION['error'] = "Error during insertion : " . mysqli_error($connexion);
            header('Location: /newconnect');
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Error preparing the query : " . mysqli_error($connexion);
        header('Location: /newconnect');
        exit;
    }
} else {
    header('Location: /newconnect');
    exit;
}

mysqli_close($connexion);
?>

