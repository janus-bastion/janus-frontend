<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = trim($_POST['totp_code']);
    if (!isset($_SESSION['pending_user'])) {
        $_SESSION['error'] = "Session expirée, veuillez vous reconnecter.";
        header("Location: /login");
        exit;
    }

    $username = $_SESSION['pending_user'];

    $sql = "SELECT id, totp_code, totp_expires_at, is_admin FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        if ($row['totp_code'] === $code && strtotime($row['totp_expires_at']) > time()) {
            $_SESSION['user'] = $username;
            $_SESSION['is_admin'] = (bool)$row['is_admin'];
            $_SESSION['last_activity'] = time();

            // Nettoyer le code en BDD
            $sqlUpdate = "UPDATE users SET totp_code = NULL, totp_expires_at = NULL WHERE id = ?";
            $stmtUpdate = mysqli_prepare($connexion, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, "i", $row['id']);
            mysqli_stmt_execute($stmtUpdate);

            unset($_SESSION['pending_user']);
            header("Location: /home");
            exit;
        } else {
            $_SESSION['error'] = "Code TOTP incorrect ou expiré.";
            header("Location: /2faverif");
            exit;
        }
    } else {
        $_SESSION['error'] = "Utilisateur introuvable.";
        header("Location: /login");
        exit;
    }
}
mysqli_close($connexion);
?>

