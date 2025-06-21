<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Janus</title>
    <style><?php include("janus-style/janus-style.css"); ?></style>
</head>
<body>
    <div class="login-container">
        <img src="janus-logo.png" alt="Janus Logo" class="form-logo">
        <h2>Connexion</h2>
        <form action="/preauthprocess" method="post">
            <input type="text" name="username_or_email" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>
