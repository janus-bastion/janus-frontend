<?php

function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception("Environment file not found: " . $filePath);
    }
    
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
        }
    }
}

loadEnv(__DIR__ . '/.env');

$servers = [
    [
        'host' => $_ENV['DB_PRIMARY_HOST'],
        'username' => $_ENV['DB_PRIMARY_USERNAME'],
        'password' => $_ENV['DB_PRIMARY_PASSWORD'],
        'dbname' => $_ENV['DB_PRIMARY_DATABASE'],
        'port' => (int)$_ENV['DB_PRIMARY_PORT'],
        'description' => 'Primary Server'
    ],
    [
        'host' => $_ENV['DB_REPLICA_HOST'],
        'username' => $_ENV['DB_REPLICA_USERNAME'],
        'password' => $_ENV['DB_REPLICA_PASSWORD'],
        'dbname' => $_ENV['DB_REPLICA_DATABASE'],
        'port' => (int)$_ENV['DB_REPLICA_PORT'],
        'description' => 'Failover Server (Replica)'
    ]
];

$connexion = null;
$last_error = '';

foreach ($servers as $server) {
    try {
        $connexion = @mysqli_connect(
            $server['host'], 
            $server['username'], 
            $server['password'], 
            $server['dbname'], 
            $server['port']
        );
        if ($connexion) {
            error_log("Connection successful to server: " . $server['description'] . " (" . $server['host'] . ")");
            break;
        }
    } catch (mysqli_sql_exception $e) {
        $last_error = $e->getMessage();
        error_log("Connection failed to server " . $server['description'] . " (" . $server['host'] . "): " . $last_error);
        continue;
    }
}

if (!$connexion) {
    die('Connection error: Unable to connect to database. Both primary and replication servers are unavailable. Last error: ' . $last_error);
}
?>
