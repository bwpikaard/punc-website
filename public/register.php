<?php
    session_start();
    
    if (isset($_SESSION["username"]) && $_SESSION["administrator"] != 1) {
        header("Location: /");
        exit;
    }

    $disabled = true;
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="/assets/js/index.js"></script>
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

        <title>Nano Cooperative</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">
                <img class="navbar-brand-image" src="/assets/images/logo.png" alt="">
                Nano Cooperative
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/conference">Conference</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/members">Members</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($_SESSION["id"] && $_SESSION["administrator"] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin" tabindex="-1">Admin</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <?php if ($_SESSION["id"]) { ?>
                        <a class="nav-link" href="/logout" tabindex="-1">Logout</a>
                        <?php } else { ?>
                            <a class="nav-link" href="/login" tabindex="-1">Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
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
                        <input <?php if ($disabled) echo "disabled "; ?>name="username" type="text" class="form-control" id="username" placeholder="Username" data-toggle="popover" data-content="Popover" data-trigger="manual" <?php if ($username) echo "value=\"$username\""; ?> required>
                        <div class="invalid-feedback">
                            Please enter a username.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="displayname">Display Name</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="displayname" type="text" class="form-control" id="displayname" placeholder="Display Name" data-toggle="popover" data-content="Popover" data-trigger="manual" required>
                        <div class="invalid-feedback">
                            Please enter a display name.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="email" type="email" class="form-control" id="email" placeholder="Email" data-toggle="popover" data-content="Popover" data-trigger="manual" required>
                        <div class="invalid-feedback">
                            Please enter a valid email.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input <?php if ($disabled) echo "disabled "; ?>name="password" type="password" class="form-control" id="password" minlength="6" maxlength="20" placeholder="Password" data-toggle="popover" data-content="Popover" data-trigger="manual" required>
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

<script>
    const params = new URLSearchParams(window.location.search);

    if (params.has("ue")) {
        $("#username").addClass("is-invalid").parent().find(".invalid-feedback").html(params.get("ue"));
    } else if (params.has("pe")) {
        $("#password").addClass("is-invalid").parent().find(".invalid-feedback").html(params.get("pe"));
    }
</script>