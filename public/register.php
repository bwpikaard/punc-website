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
        <title>Nano Cooperative</title>
    </head>
    <body>
        <?php include "../resources/templates/navbar.php"; ?>
        <div class="login">
            <div class="frame">
                <?php if ($disabled) { ?>
                    <label style="color: red;">Registration Disabled</label>
                <?php } ?>
                <form class="needs-validation" action="/utilities/users" method="post" novalidate>
                    <input type="hidden" name="register">
                    <label class="title">Create an Account</label>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="username" type="text" class="form-control" id="username" placeholder="Username" required>
                        <div class="invalid-feedback">
                            Please enter a username.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="displayname">Display Name</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="displayname" type="text" class="form-control" id="displayname" placeholder="Display Name" required>
                        <div class="invalid-feedback">
                            Please enter a display name.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="email" type="email" class="form-control" id="email" placeholder="Email" required>
                        <div class="invalid-feedback">
                            Please enter a valid email.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="password" type="password" class="form-control" id="password" minlength="6" maxlength="20" placeholder="Password" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">Your password must be between 6 and 20 characters.</small>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>
                    <button <?php if ($disabled) echo "disabled "; ?>type="submit" class="btn btn-outline-primary btn-sm">Register</button>
                    <a class="btn btn-outline-light btn-sm" href="/login">Already have an account?</a>
                </form>
            </div>
        </div>
    </body>
</html>