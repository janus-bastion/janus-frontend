<?php
session_start();

if (!isset($_SESSION['user']) || !($_SESSION['is_admin'] ?? false)) {
    header("Location: /login");
    exit;
}

require_once '../janus-include/header.php';
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

// Handle update form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int) $_POST['user_id'];
    $new_is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $connexion->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_is_admin, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: /manage-users");
    exit;
}

// Fetch all users
$users = [];
$result = $connexion->query("SELECT id, username, email, is_admin FROM users");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->close();
}
?>

<style>
    body {
        background-color: #414856 !important;
        min-height: 100vh;
        margin: 0;
        padding: 1em;
        font-family: Arial, sans-serif;
        color: white;
    }
    h1 {
        text-align: center;
        margin-bottom: 1.5em;
    }
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5em;
    }
    .connection-card {
        background-color: #2e323f;
        border-radius: 8px;
        padding: 1.2em;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1em;
    }
    .card-header h2 {
        font-size: 1.2em;
        margin: 0;
    }
    .admin-checkbox {
        transform: scale(1.4);
        margin-left: 0.5em;
    }
    .submit-btn {
        background-color: #4caf50;
        border: none;
        padding: 0.5em 1em;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        font-weight: bold;
    }
    .submit-btn:hover {
        background-color: #45a049;
    }
</style>

<h1>Administrator Management</h1>

<div class="cards-grid">
    <?php foreach ($users as $user): ?>
        <div class="connection-card">
            <form method="POST">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <div class="card-header">
                    <h2><?= htmlspecialchars($user['username']) ?></h2>
                    <label>
                        Admin?
                        <input type="checkbox" class="admin-checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>>
                    </label>
                </div>
                <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                <button type="submit" class="submit-btn">Update</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../janus-include/footer.php'; ?>

