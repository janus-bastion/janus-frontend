<?php

include '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($connexion, $_POST['username']);
    $pass = mysqli_real_escape_string($connexion, $_POST['password']); // Penser ensuite à hacher le mot de passe

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header("Location: ../janus-view/accueil.php");
            exit;
        } else {
            echo "Erreur : Aucune ligne insérée.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur SQL : " . mysqli_error($connexion);
    }
}

mysqli_close($connexion);
?>

