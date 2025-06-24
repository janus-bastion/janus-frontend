<?php
session_start();

require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';
require_once __DIR__ . '/janus-auth-utils.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = mysqli_real_escape_string($connexion, $_POST['username_or_email']);
    $pass = mysqli_real_escape_string($connexion, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $input, $input);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($pass, $user['password'])) {

            if (isset($user['password_changed_at'])) {
                $passwordChangedAt = strtotime($user['password_changed_at']);
                $threeMonthsAgo = strtotime('-3 months');

                if ($passwordChangedAt < $threeMonthsAgo) {
                    $_SESSION['force_password_change'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: /changepassword");
                    exit;
                }
            }

            $_SESSION['user'] = $user['username'];
            $_SESSION['is_admin'] = (int) $user['is_admin'];

            if ($user['username'] === 'janusadmin') {
                $_SESSION['is_admin'] = 1;
                header("Location: /home");
                exit;
            }

            $code = generateTotpCode();
            $expiresAt = date('Y-m-d H:i:s', time() + 300);

            $sqlUpdate = "UPDATE users SET totp_code = ?, totp_expires_at = ? WHERE id = ?";
            $stmtUpdate = mysqli_prepare($connexion, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, "ssi", $code, $expiresAt, $user['id']);
            mysqli_stmt_execute($stmtUpdate);

            if (sendTotpCodeEmail($user['email'], $code)) {
                $_SESSION['pending_user'] = $user['username'];
                header("Location: /2faverif");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'envoi du code par mail.";
                header("Location: /login");
                exit;
            }

        } else {
            $_SESSION['error'] = "Mot de passe incorrect.";
            header("Location: /login");
            exit;
        }
    } else {
        $_SESSION['error'] = "Utilisateur non trouvé.";
        header("Location: /login");
        exit;
    }
}

mysqli_close($connexion);
?>

