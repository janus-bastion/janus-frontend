<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($connexion, $_POST['username']);
    $pass = mysqli_real_escape_string($connexion, $_POST['password']);

    // Préférez password_hash() et password_verify() pour les mots de passe
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if ($result && mysqli_num_rows($result) === 1) {
                $_SESSION['user'] = $user;
                $_SESSION['last_activity'] = time();
                header("Location: ../janus-view/home.php");
                exit;
            }
        }
    }
    
    $_SESSION['error'] = "Identifiants incorrects";
    header("Location: ../index.html");
    exit;
}

mysqli_close($connexion);
?>