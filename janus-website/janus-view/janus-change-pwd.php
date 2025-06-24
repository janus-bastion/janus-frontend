<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Expired</title>
    <style><?php include("../janus-style/janus-style.css"); ?></style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <img src="janus-logo.png" alt="Janus Logo" class="form-logo">
        <h2>Password Expired</h2>

        <div class="alert alert-warning" role="alert">
            Your password has expired. Please set a new one.
        </div>

        <form action="/processchangepass" method="post">
            <input type="password" name="new_password" placeholder="New password" required>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            <input type="submit" value="Change Password">
        </form>
    </div>
</body>
</html>

