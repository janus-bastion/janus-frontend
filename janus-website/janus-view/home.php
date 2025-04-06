<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../janus-include/header.php';
?>

Foo bar :)

<?php require_once '../janus-include/footer.php'; ?>