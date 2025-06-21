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
            <a href="/home"> <!-- Redirects to home page -->
                <img src="janus-logo.png" alt="Janus Logo" class="nav-logo">
            </a>
            <span class="nav-title">Janus</span>
        </div>
        <nav class="nav-right">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-buttons">
                    <a href="/register">New user</a>
                    <a href="/newconnect">New connection</a>
                    <a href="/dashboard">Dashboard</a>
                    <a href="/logout">Logout</a>
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
