<?php

$host = 'janus-mysql';  // Le nom du serveur
$username = 'root';      // L'utilisateur de la base de données
$password = 'root';      // Le mot de passe de l'utilisateur
$dbname = 'janus_db';  // Le nom de la base de données
$port = 3306;            // Le port utilisé par MySQL

$connexion = mysqli_connect($host, $username, $password, $dbname, $port);

if (!$connexion) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}
?>
