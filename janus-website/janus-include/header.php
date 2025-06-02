<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style><?php include("../janus-style/janus-style.css"); ?></style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <header class="top-nav">
        <div class="nav-left">
            <!-- Logo link only -->
            <a href="../janus-view/home.php"> <!-- Redirects to home page -->
                <img src="../janus-logo.png" alt="Janus Logo" class="nav-logo">
            </a>
            <span class="nav-title">Janus</span>
        </div>
        <nav class="nav-right">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-buttons">
                    <a href="janus-register.php">New user</a>
                    <a href="janus-create-connect.php">New connection</a>
                    <a href="janus-dashboard.php">Dashboard</a>
                    <a href="janus-logout.php">Logout</a>
                </div>
                <span class="connection-status connected">
                    <?= htmlspecialchars($_SESSION['user']) ?> connected
                </span>
            <?php else: ?>
                <span class="connection-status disconnected">
                    Disconnected
                </span>
            <?php endif; ?>
        </nav>
    </header>
    <main class="main-content">
