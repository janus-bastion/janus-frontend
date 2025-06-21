<?php
session_start();
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = mysqli_real_escape_string($connexion, $_POST['username_or_email']);
    $pass = mysqli_real_escape_string($connexion, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $input);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $stored_hash = $row['password'];

                if (password_verify($pass, $stored_hash)) {
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['last_activity'] = time();
                    header("Location: /home");
                    exit;
                } else {
                    $_SESSION['error'] = "Incorrect password";
                    header("Location: /login");
                    exit;
                }
            }
        }
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $input);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $stored_hash = $row['password'];

                if (password_verify($pass, $stored_hash)) {
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['last_activity'] = time();
                    header("Location: /home");
                    exit;
                } else {
                    $_SESSION['error'] = "Incorrect password";
                    header("Location: /login");
                    exit;
                }
            }
        }
    }

    $_SESSION['error'] = "Incorrect credentials";
    header("Location: /login");
    exit;
}

mysqli_close($connexion);
?>
