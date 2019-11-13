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
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <div class="login">
            <div class="frame">
                <form class="needs-validation" action="/utilities/users" method="post" novalidate>
                    <input type="hidden" name="login">
                    <label class="title">Login</label>
                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <input name="username" type="text" class="form-control" id="username" placeholder="Username or Email" <?php if ($username) echo "value=\"$username\""; ?> required>
                        <div class="invalid-feedback">
                            Please enter your username or email.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-sm">Login</button>
                    <a class="btn btn-outline-light btn-sm" href="/register">Need an account?</a>
                </form>
            </div>
        </div>
    </body>
</html>