<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TOTP Verification - Janus</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .totp-container { max-width: 400px; margin: 100px auto; background: white; padding: 20px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type=text] { width: 100%; padding: 10px; margin-top: 10px; font-size: 1.2em; }
        input[type=submit] { margin-top: 15px; padding: 10px; width: 100%; font-size: 1.2em; background: #0078D7; color: white; border: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="totp-container">
        <h2>Enter your verification code</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/2faverifuser" method="post">
            <input type="text" name="totp_code" placeholder="6-digit code" maxlength="6" pattern="\d{6}" required autofocus>
            <input type="submit" value="Verify">
        </form>
    </div>
</body>
</html>

