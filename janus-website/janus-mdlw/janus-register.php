<?php
// Connexion à la base de données
include '/home/janus-storage/janus-db-connect/janus-db-connection.php';

// Vérifie que la méthode est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Échappement des données utilisateur
    $username = mysqli_real_escape_string($connexion, $_POST['username']);
    $email = mysqli_real_escape_string($connexion, $_POST['email']);
    // Hachage sécurisé du mot de passe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Préparation de la requête SQL
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        // Liaison des paramètres
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
        $success = mysqli_stmt_execute($stmt);

        if ($success && mysqli_stmt_affected_rows($stmt) > 0) {
            // Redirection si succès
            header("Location: ../janus-view/home.php");
            exit;
        } else {
            // Gestion des erreurs (par ex. doublon)
            echo "<div style='color: red; padding: 20px; font-weight: bold;'>Erreur : Le nom d'utilisateur ou l'email est peut-être déjà utilisé.</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Erreur SQL
        echo "<div style='color: red; padding: 20px; font-weight: bold;'>Erreur SQL : " . mysqli_error($connexion) . "</div>";
    }
}

mysqli_close($connexion);
?>

