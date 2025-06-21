<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout Confirmation - Janus</title>
    <style><?php include("../janus-style/janus-style-logout.css"); ?></style>
</head>
<body>
    <div class="logout-container">
        <h1>Logout Confirmation</h1>
        <div class="message">
            Are you sure you want to log out from Janus system?
        </div>
        <div class="buttons">
            <form action="/logoutprocess" method="post">
                <button type="submit" class="btn btn-logout">Yes, log me out</button>
            </form>
            <a href="javascript:history.back()" class="btn btn-cancel">Cancel</a>
        </div>
    </div>
</body>
</html>
