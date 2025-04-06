<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de déconnexion - Janus</title>
    <style><?php include("../janus-style/janus-style-logout.css"); ?></style>
</head>
<body>
    <div class="logout-container">
        <h1>Confirmation de déconnexion</h1>
        <div class="message">
            Êtes-vous sûr de vouloir vous déconnecter du système Janus ?
        </div>
        <div class="buttons">
            <form action="../janus-mdlw/janus-logout.php" method="post">
                <button type="submit" class="btn btn-logout">Oui, me déconnecter</button>
            </form>
            <a href="javascript:history.back()" class="btn btn-cancel">Annuler</a>
        </div>
    </div>
</body>
</html>