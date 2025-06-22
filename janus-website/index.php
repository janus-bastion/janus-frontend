<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Janus Login</title>
    <style><?php include("janus-style/janus-style.css"); ?></style>
</head>
<body>
    <div class="login-container">
        <img src="janus-logo.png" alt="Janus Logo" class="form-logo">
        <h2>Login</h2>
        <form action="/preauthprocess" method="post">
            <input type="text" name="username_or_email" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Log in">
        </form>
    </div>
</body>
</html>
