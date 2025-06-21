<?php
session_start();
include '/home/janus-storage/janus-db-connect/janus-db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($connexion, $_POST['username']);
    $email = mysqli_real_escape_string($connexion, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkUserSql = "SELECT id FROM users WHERE username = ?";
    $checkUserStmt = mysqli_prepare($connexion, $checkUserSql);

    if ($checkUserStmt) {
        mysqli_stmt_bind_param($checkUserStmt, "s", $username);
        mysqli_stmt_execute($checkUserStmt);
        mysqli_stmt_store_result($checkUserStmt);

        if (mysqli_stmt_num_rows($checkUserStmt) > 0) {
            $_SESSION['register_error'] = "This username is already taken.";
            header("Location: /register");
            exit;
        }
        mysqli_stmt_close($checkUserStmt);
    }

    $checkEmailSql = "SELECT id FROM users WHERE email = ?";
    $checkEmailStmt = mysqli_prepare($connexion, $checkEmailSql);

    if ($checkEmailStmt) {
        mysqli_stmt_bind_param($checkEmailStmt, "s", $email);
        mysqli_stmt_execute($checkEmailStmt);
        mysqli_stmt_store_result($checkEmailStmt);

        if (mysqli_stmt_num_rows($checkEmailStmt) > 0) {
            $_SESSION['register_error'] = "This email is already in use.";
            header("Location: /register");
            exit;
        }
        mysqli_stmt_close($checkEmailStmt);
    }

    $insertSql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $insertStmt = mysqli_prepare($connexion, $insertSql);

    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, "sss", $username, $email, $password);
        $success = mysqli_stmt_execute($insertStmt);

        if ($success && mysqli_stmt_affected_rows($insertStmt) > 0) {
            unset($_SESSION['register_error']);
            header("Location: /home");
            exit;
        } else {
            $_SESSION['register_error'] = "An error occurred during registration.";
            header("Location: /register");
            exit;
        }

        mysqli_stmt_close($insertStmt);
    } else {
        $_SESSION['register_error'] = "SQL Error : " . mysqli_error($connexion);
        header("Location: /register");
        exit;
    }
}

mysqli_close($connexion);
?>

