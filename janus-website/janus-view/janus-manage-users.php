<?php
session_start();

if (!isset($_SESSION['user']) || !($_SESSION['is_admin'] ?? false)) {
    header("Location: /login");
    exit;
}

require_once '../janus-include/header.php';
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int) $_POST['user_id'];

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $connexion->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: /manage-users");
        exit;
    }

    $new_is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $stmt = $connexion->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_is_admin, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: /manage-users");
    exit;
}

$users = [];
$result = $connexion->query("SELECT id, username, email, is_admin FROM users");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->close();
}
?>

<style><?php include("../janus-style/janus-style.css"); ?></style>

<div class="cards-grid">
    <?php foreach ($users as $user): ?>
        <div class="connection-card">
            <form method="POST">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <div class="card-header">
                    <h2><?= htmlspecialchars($user['username']) ?></h2>
                    <label class="admin-label">
                        &ensp;Admin?
                        <input type="checkbox" class="admin-checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>>
                    </label>
                </div>
                <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                <div class="action-buttons">
                    <button type="submit" class="submit-btn">Update</button>
                    <button type="button" class="delete-btn" onclick="showConfirm(<?= $user['id'] ?>)">Delete</button>
                    <button type="submit" name="action" value="delete" id="confirm-<?= $user['id'] ?>" class="confirm-delete-btn hidden">
                        Are you sure to delete?
                    </button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function showConfirm(id) {
        document.getElementById('confirm-' + id).classList.remove('hidden');
    }
</script>

<?php require_once '../janus-include/footer.php'; ?>

