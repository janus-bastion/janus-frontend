<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Vous devez être connecté pour ajouter une connexion distante.";
    header("Location: ../janus-view/home.php");
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
        $_SESSION['error'] = "Utilisateur introuvable dans la base de données.";
        header("Location: ../janus-view/home.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Erreur de requête : " . mysqli_error($connexion);
    header("Location: ../janus-view/home.php");
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

    // ✅ Vérification si le nom de connexion existe déjà pour cet utilisateur
    $check_sql = "SELECT id FROM remote_connections WHERE user_id = ? AND name = ?";
    $check_stmt = mysqli_prepare($connexion, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "is", $user_id, $connection_name);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        $_SESSION['error'] = "Une connexion avec ce nom existe déjà.";
        mysqli_stmt_close($check_stmt);
        header('Location: ../janus-view/janus-create-connect.php');
        exit;
    }
    mysqli_stmt_close($check_stmt);

    $sql = "INSERT INTO remote_connections (user_id, name, protocol, host, port, username, password)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connexion, $sql)) {
        mysqli_stmt_bind_param($stmt, "isssiss", $user_id, $connection_name, $protocol, $ip_address, $port, $username_conn, $password);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Connexion créée avec succès!";
            header('Location: ../janus-view/janus-dashboard.php');
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de l'insertion : " . mysqli_error($connexion);
            header('Location: ../janus-view/janus-create-connect.php');
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Erreur de préparation de la requête : " . mysqli_error($connexion);
        header('Location: ../janus-view/janus-create-connect.php');
        exit;
    }
} else {
    header('Location: ../janus-view/janus-create-connect.php');
    exit;
}

mysqli_close($connexion);
?>

