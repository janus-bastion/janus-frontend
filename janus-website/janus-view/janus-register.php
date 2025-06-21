<?php
session_start();

require_once '../janus-include/header.php';
?>

<style>
    body {
        background-color: #414856 !important;
        min-height: 100vh;
        margin: 0;
    }
</style>

<div class="main-content">
    <div style="background-color: #2f3640; padding: 30px; border-radius: 10px; max-width: 400px; width: 100%; box-shadow: 0 4px 10px rgba(0,0,0,0.3); margin: auto;">
        <h2 style="margin-bottom: 20px; text-align: center; color: #fff;">Create New User</h2>

        <?php if (isset($_SESSION['register_error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_SESSION['register_error']) ?>
            </div>
            <?php unset($_SESSION['register_error']); ?>
        <?php endif; ?>

        <form action="/registerprocess" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="username" placeholder="Username" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="email" name="email" placeholder="Email" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; border-radius: 6px; border: none;">
            <button type="submit" style="padding: 10px; background-color: #5684AE; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">
                Create User
            </button>
        </form>
    </div>
</div>

