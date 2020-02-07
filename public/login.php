<?php
    session_start();

    if (isset($_SESSION["id"])) {
        header("Location: /");
        exit;
    }
    
    if (isset($_GET["username"])) $username = $_GET["username"];
?>

<!DOCTYPE html>

<html>
    <head>
        <?php include "../resources/templates/head.php"; ?>
        <script src="/assets/js/validation.js"></script>
        <link rel="stylesheet" href="/assets/css/login.css">
        <title>Nevis Investing</title>
    </head>
    <body>
        <div class="login">
            <div class="panel">
                <h2>Welcome</h2>
                <br>
                <form class="needs-validation" action="/utilities/users" method="post" novalidate>
                    <input type="hidden" name="login">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input name="username" type="text" class="form-control" id="username" <?php if ($username) echo "value=\"$username\""; ?> required>
                        <div class="invalid-feedback">
                            Please enter your username or email.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Login</button>
                </form>
                <p class="signup">Don't have an account? <a href="/register">Sign Up</a></p>
            </div>
        </div>
    </body>
</html>