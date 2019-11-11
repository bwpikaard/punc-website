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
        <meta charset="utf-8">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://nanocooperative.com">
        <meta property="og:title" content="Nano Cooperative">
        <meta property="og:description" content="Primarily Undergraduate Nanomaterials Cooperative (PUNK)">
        <meta property="og:site_name" content="Nano Cooperative">
        <meta property="og:image" content="https://nanocooperative.com/assets/images/icon.png">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="/assets/images/icon.png" rel="icon" type="image/x-icon">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
        <script src="/assets/js/index.js"></script>
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
                        <input name="username" type="text" class="form-control" id="username" placeholder="Username or Email" data-toggle="popover" data-content="Popover" data-trigger="manual" <?php if ($username) echo "value=\"$username\""; ?> required>
                        <div class="invalid-feedback">
                            Please enter your username or email.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" data-toggle="popover" data-content="Popover" data-trigger="manual" required>
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