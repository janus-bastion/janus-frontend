<?php
session_start();

require_once '../janus-include/header.php';

?>

<div class="main-content">
    <div style="background-color: #2f3640; padding: 30px; border-radius: 10px; max-width: 500px; width: 100%; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
        <h2 style="margin-bottom: 20px; text-align: center; color: #fff;">Nouvelle connexion à distance</h2>
        <form action="../janus-mdlw/janus-create-connect.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="connection_name" placeholder="Nom de la connexion" required style="padding: 10px; border-radius: 6px; border: none;">
            
            <select name="protocol" required style="padding: 10px; border-radius: 6px; border: none; color: #555;">
                <option value="">-- Sélectionnez un protocole --</option>
                <option value="ssh">SSH</option>
                <option value="vnc">VNC</option>
                <option value="rdp">RDP</option>
            </select>
            
            <input type="text" name="ip_address" placeholder="Adresse IP" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="number" name="port" placeholder="Port (vide pour défaut)" style="padding: 10px; border-radius: 6px; border: none;">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="password" name="password" placeholder="Mot de passe" style="padding: 10px; border-radius: 6px; border: none;">
            <textarea name="notes" placeholder="Notes supplémentaires" style="padding: 10px; border-radius: 6px; border: none; min-height: 80px;"></textarea>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 10px; background-color: #5684AE; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; flex: 1;">
                    Créer la connexion
                </button>
                <a href="javascript:history.back()" style="padding: 10px; background-color: #555; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; text-align: center; text-decoration: none; flex: 1;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../janus-include/footer.php'; ?>
