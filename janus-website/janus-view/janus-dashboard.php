<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../janus-include/header.php';
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

?>
<style>
    body {
        background-color: #414856 !important;
        min-height: 100vh;
        margin: 0;
    }
</style>

<?php

$username = $_SESSION['user'];

// Get user ID
$query = "SELECT id FROM users WHERE username = ?";
if ($stmt = mysqli_prepare($connexion, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $userId);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (empty($userId)) {
        $_SESSION['error'] = "User not found in database.";
        header("Location: ../janus-view/home.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Query error: " . mysqli_error($connexion);
    header("Location: ../janus-view/home.php");
    exit;
}

// Get connections
$connections = [];
$query = "SELECT * FROM remote_connections WHERE user_id = ?";
if ($stmt = mysqli_prepare($connexion, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $connections[] = $row;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<p>Error retrieving connections: " . mysqli_error($connexion) . "</p>";
}
?>

<!-- Main content -->
<div class="main-content">
    <!-- Top search bar -->
    <div class="search-bar-container">
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterConnections()">
    </div>

    <!-- Connection cards -->
    <div class="cards-grid" id="cardsContainer">
        <?php if (count($connections) === 0): ?>
            <p>No saved connections.</p>
        <?php else: ?>
            <?php foreach ($connections as $conn): ?>
                <div class="connection-card">
                    <div class="card-header">
                        <h2><?= htmlspecialchars($conn['name']) ?></h2>
                        <span class="toggle-eye" onclick="toggleDetails(this)">
                            👁️
                        </span>
                    </div>
                    
                    <div class="connection-details" style="display: none;">
                        <p style="color: white;"><strong>Protocol:</strong> <?= htmlspecialchars($conn['protocol']) ?></p>
                        <p style="color: white;"><strong>IP Address:</strong> <?= htmlspecialchars($conn['host']) ?></p>
                        <p style="color: white;"><strong>Port:</strong> <?= htmlspecialchars($conn['port']) ?></p>
                        <p style="color: white;"><strong>Username:</strong> <?= htmlspecialchars($conn['username']) ?></p>
                        <p style="color: white;"><small>Added on <?= htmlspecialchars($conn['created_at']) ?></small></p>
                    </div>
                    
                    <a href="connect.php?id=<?= $conn['id'] ?>" class="connect-button" title="Connect">
                        🔌
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Search JavaScript -->
<script>
function filterConnections() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const cards = document.querySelectorAll(".connection-card");

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(filter) ? "" : "none";
    });
}

function toggleDetails(eyeIcon) {
    const card = eyeIcon.closest('.connection-card');
    const details = card.querySelector('.connection-details');
    
    if (details.style.display === 'none') {
        details.style.display = 'block';
        eyeIcon.textContent = '👁️';
    } else {
        details.style.display = 'none';
        eyeIcon.textContent = '👁️';
    }
}
</script>

<?php require_once '../janus-include/footer.php'; ?>
