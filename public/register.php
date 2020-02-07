<?php
    session_start();
    
    if (isset($_SESSION["username"])) {
        header("Location: /");
        exit;
    }

    $disabled = true;
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
        <?php //include "../resources/templates/navbar.php"; ?>
        <div class="login">
            <div class="panel">
                <?php if ($disabled) { ?>
                    <h2>Registration is Disabled</h2>
                    <p class="signup">Already have an account? <a href="/login">Log In</a></p>
                <?php } else { ?>
                    <h2>Create an Account</h2>
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
                        <button type="submit" class="btn-submit">Sign Up</button>
                        <?php if ($disabled) { ?>
                            <br><label style="color: red;">Registration Disabled</label>
                        <?php } ?>
                    </form>
                    <p class="signup">Already have an account? <a href="/login">Log In</a></p>
                <?php } ?>
            </div>
        </div>
    </body>
</html>