<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Janus</title>
    <link rel="stylesheet" type="text/css" href="janus-style/janus-style.css">
</head>
<body>
    <div class="login-container">
        <img src="janus-logo.png" alt="Janus Logo" class="logo">
        <h2>Connexion</h2>
        <form action="janus-mdlw/janus-preauth.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>
