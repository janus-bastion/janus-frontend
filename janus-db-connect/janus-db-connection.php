<?php
$env = parse_ini_file(__DIR__ . '/.env');

$host = $env['DB_HOST'];
$port = $env['DB_PORT'];
$dbname = $env['DB_NAME'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];

$connexion = mysqli_connect($host, $username, $password, $dbname, $port);

if (!$connexion) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}
?>

