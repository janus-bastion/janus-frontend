<?php

require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';
header('Content-Type: application/json');

// Fonction pour formater la date
function formatDateLabel($date) {
    return date('d/m/Y', strtotime($date));
}

// 1. Statistiques des utilisateurs créés par période (7 derniers jours)
$usersData = [];
$labels = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = formatDateLabel($date);
    
    $query = "SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = '$date'";
    $result = mysqli_query($connexion, $query);
    $row = mysqli_fetch_assoc($result);
    $usersData[] = (int)$row['count'];
}

// 2. Répartition des types de connexions
$connectionTypes = [
    'labels' => ['SSH', 'VNC', 'RDP'],
    'data' => [0, 0, 0]
];

$query = "SELECT protocol, COUNT(*) as count FROM remote_connections GROUP BY protocol";
$result = mysqli_query($connexion, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $index = array_search(strtolower($row['protocol']), ['ssh', 'vnc', 'rdp']);
    if ($index !== false) {
        $connectionTypes['data'][$index] = (int)$row['count'];
    }
}

// 3. Évolution des connexions créées (7 derniers jours)
$connectionsOverTime = [
    'labels' => $labels, // On réutilise les mêmes labels que pour les utilisateurs
    'data' => []
];

foreach ($labels as $label) {
    $date = date('Y-m-d', strtotime(str_replace('/', '-', $label)));
    $query = "SELECT COUNT(*) as count FROM remote_connections WHERE DATE(created_at) = '$date'";
    $result = mysqli_query($connexion, $query);
    $row = mysqli_fetch_assoc($result);
    $connectionsOverTime['data'][] = (int)$row['count'];
}

// Retourner toutes les données en JSON
echo json_encode([
    'users' => [
        'labels' => $labels,
        'data' => $usersData
    ],
    'connectionTypes' => $connectionTypes,
    'connectionsOverTime' => $connectionsOverTime
]);

mysqli_close($connexion);
?>
