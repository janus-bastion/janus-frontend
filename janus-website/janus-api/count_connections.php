<?php
require_once '/usr/share/nginx/html/janus-api/auth_admin.php';

$sql = "SELECT COUNT(*) AS total FROM remote_connections";
$result = mysqli_query($connexion, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['total'];
}

mysqli_close($connexion);

