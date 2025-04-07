<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = mysqli_real_escape_string($connexion, $_POST['username_or_email']);
    $pass = mysqli_real_escape_string($connexion, $_POST['password']);

    // Première requête pour chercher par nom d'utilisateur
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $input);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            // Si un utilisateur est trouvé par le nom d'utilisateur
            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $stored_hash = $row['password']; // Mot de passe haché dans la base

                // Vérification du mot de passe avec password_verify()
                if (password_verify($pass, $stored_hash)) {
                    $_SESSION['user'] = $row['username'];  // Nom d'utilisateur dans la session
                    $_SESSION['last_activity'] = time();
                    header("Location: ../janus-view/home.php");
                    exit;
                } else {
                    // Mot de passe incorrect
                    $_SESSION['error'] = "Mot de passe incorrect";
                    header("Location: ../index.html");
                    exit;
                }
            }
        }
    }

    // Si la première requête échoue, essayer avec l'email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $input);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            // Si un utilisateur est trouvé par l'email
            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $stored_hash = $row['password']; // Mot de passe haché dans la base

                // Vérification du mot de passe avec password_verify()
                if (password_verify($pass, $stored_hash)) {
                    $_SESSION['user'] = $row['username'];  // Nom d'utilisateur dans la session
                    $_SESSION['last_activity'] = time();
                    header("Location: ../janus-view/home.php");
                    exit;
                } else {
                    // Mot de passe incorrect
                    $_SESSION['error'] = "Mot de passe incorrect";
                    header("Location: ../index.html");
                    exit;
                }
            }
        }
    }

    // Si aucun utilisateur n'a été trouvé
    $_SESSION['error'] = "Identifiants incorrects";
    header("Location: ../index.html");
    exit;
}

mysqli_close($connexion);
?>
