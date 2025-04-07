<?php
// Démarrer la session
session_start();

require_once '../janus-include/header.php';
?>

<div class="main-content">
    <div style="background-color: #2f3640; padding: 30px; border-radius: 10px; max-width: 400px; width: 100%; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
        <h2 style="margin-bottom: 20px; text-align: center; color: #fff;">Créer un nouvel utilisateur</h2>
        <form action="../janus-mdlw/janus-register.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="email" name="email" placeholder="Email" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="password" name="password" placeholder="Mot de passe" required style="padding: 10px; border-radius: 6px; border: none;">
            <button type="submit" style="padding: 10px; background-color: #5684AE; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">
                Créer l'utilisateur
            </button>
        </form>
    </div>
</div>

<?php require_once '../janus-include/footer.php'; ?>

