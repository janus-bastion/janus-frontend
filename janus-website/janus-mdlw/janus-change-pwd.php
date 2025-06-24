<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if (!isset($_SESSION['force_password_change']) || !isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = mysqli_real_escape_string($connexion, $_POST['new_password']);
    $confirmPassword = mysqli_real_escape_string($connexion, $_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: /changepassword");
        exit;
    } elseif (strlen($newPassword) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header("Location: /changepassword");
        exit;
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $userId = $_SESSION['user_id'];

        $sql = "UPDATE users SET password = ?, password_changed_at = NOW() WHERE id = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $userId);
        mysqli_stmt_execute($stmt);

        unset($_SESSION['force_password_change']);
        unset($_SESSION['user_id']);

        $_SESSION['message'] = "Password updated successfully. Please log in.";
        header("Location: /login");
        exit;
    }
}
?>

