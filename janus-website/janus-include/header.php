<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style><?php include("../janus-style/janus-style.css"); ?></style>
</head>
<body>
    <header class="top-nav">
        <div class="nav-left">
            <img src="../janus-logo.png" alt="Logo Janus" class="nav-logo">
            <span class="nav-title">Janus</span>
        </div>
        <nav class="nav-right">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-buttons">
                    <a href="janus-register.php">Nouvel utilisateur</a>
                    <a href="janus-create-connect.php">Nouvelle connexion</a>
                    <a href="janus-logout.php">Déconnexion</a>
                </div>
                <span class="connection-status connected">
                    <?= htmlspecialchars($_SESSION['user']) ?> connecté
                </span>
            <?php else: ?>
                <span class="connection-status disconnected">
                    Déconnecté
                </span>
            <?php endif; ?>
        </nav>
    </header>
    <main class="main-content">
