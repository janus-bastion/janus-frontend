<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Janus - Administration</title>
    <style>
        /* ------------------------------ Style général du site ------------------------------ */
        body {
            font-family: Arial, sans-serif;
            background-color: #414856;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        
        /* Contenu principal (sous la nav) */
        .main-content {
            padding-top: 80px; /* espace sous la barre de nav */
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px);
        }
        
        /* ------------------------------ Barre de navigation en haut ------------------------------ */
        .top-nav {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #313137;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
            z-index: 9999;
            box-sizing: border-box; /* Ajouté pour inclure padding dans le width */
        }
        
        /* Logo et titre dans la barre de navigation */
        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }
        
        .nav-logo {
            width: 120px;
            height: auto;
            display: block;
        }
        
        .nav-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
        
        /* Navigation à droite */
        .nav-right {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            flex: 1;
            min-width: 0; /* Permet le rétrécissement */
        }
        
        .nav-buttons {
            display: flex;
            gap: 15px;
            flex-shrink: 0;
        }
        
        .nav-right a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 16px;
            background-color: #5684AE;
            border-radius: 6px;
            transition: background-color 0.3s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        .nav-right a:hover {
            background-color: #46698C;
        }
        
        .connection-status {
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            margin-left: 10px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        .connected {
            background-color: #4CAF50; /* Vert */
        }
        
        .disconnected {
            background-color: #F44336; /* Rouge */
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <header class="top-nav">
        <div class="nav-left">
            <img src="../janus-logo.png" alt="Logo Janus" class="nav-logo">
            <span class="nav-title">Janus</span>
        </div>
        <nav class="nav-right">
            <div class="nav-buttons">
                <a href="../janus-mdlw/janus-register.php">Nouvel utilisateur</a>
                <a href="../janus-mdlw/janus-create-connect.php">Nouvelle connexion</a>
                <a href="janus-logout.php">Déconnexion</a>
            </div>
            <span class="connection-status <?php echo isset($_SESSION['user']) ? 'connected' : 'disconnected'; ?>">
                <?php echo isset($_SESSION['user']) ? 'Connecté' : 'Déconnecté'; ?>
            </span>
        </nav>
    </header>
    
    <!-- Corps vide ou autre contenu -->
    <main class="main-content">
        <!-- contenu ici -->
    </main>
    
    <?php session_start(); ?>
</body>
</html>
