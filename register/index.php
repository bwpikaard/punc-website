<!DOCTYPE html>

<?php
    require("../db.php");
    session_start();
    
    if (isset($_SESSION["username"]) && $_SESSION["administrator"] != 1) {
        header("Location: /");
        exit;
    }
    
    $disabled = true;

    if (!$disabled && isset($_POST["username"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        if (empty($username)) $username_err = "Please enter a email.";
        else if (empty($password)) $password_err = "Please enter a password.";
        else if (strlen($password) < 6) $password_err = "Password must have at least 6 characters.";

        if (empty($username_err) && empty($password_err)) {
            $username = mysqli_real_escape_string($con, $username);
            $user_stmt = "SELECT * FROM users WHERE username='$username'";
            $user_result = mysqli_query($con, $user_stmt);
            $user = mysqli_fetch_array($user_result);

            if ($user) {
                $username_err = "An account with that email already exists.";
            } else {
                $hpassword = mysqli_real_escape_string($con, password_hash($password, PASSWORD_DEFAULT));
                $created = date("Y-m-d H:i:s");

                $create_stmt = "INSERT INTO users (username, password, administrator, created) VALUES ('$username', '$hpassword', '0', '$created')";
                $create_result = mysqli_query($con, $create_stmt);

                if ($create_result) {
                    if ($_POST["return"]) {
                        header("Location: " . $_POST["return"]);
                    } else {
                        header("Location: /login?username=$username");
                    }
                } else {
                    echo mysqli_error($con);
                }
            }
        }
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/assets/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

        <title>P.U.N.C.</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">
                <img class="navbar-brand-image" src="/assets/images/logo.png" alt="">
                P.U.N.C.
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
                        <a class="nav-link" href="/conferences">Conferences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/members">Members</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($_SESSION["id"] && $_SESSION["administrator"] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/panel" tabindex="-1">Admin Panel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/panel/posts" tabindex="-1">Posts</a>
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
                <form action="/register/index.php" method="post">
                    <label class="title">Create an Account</label>
                    <input <?php if ($disabled) echo "disabled"; ?> name="username" type="email" class="form-control" id="login-email" placeholder="Email" data-toggle="popover" data-content="Popover title" data-trigger="manual">
                    <input <?php if ($disabled) echo "disabled"; ?> name="password" type="password" class="form-control" id="login-password" placeholder="Password" data-toggle="popover" data-content="Popover title" data-trigger="manual">
                    <button <?php if ($disabled) echo "disabled"; ?> type="submit" class="btn btn-outline-primary btn-sm">Register</button>
                    <a class="btn btn-outline-light btn-sm" href="/login">Already have an account?</a>
                </form>
            </div>
        </div>
    </body>
</html>

<script>
    $(function () {
        $("[data-toggle=\"popover\"]").popover();
    })
    <?php if ($username_err) { ?>
        $("#login-email").attr("data-content", "<?php echo $username_err; ?>").popover("show");
    <?php } ?>
    <?php if ($password_err) { ?>
        $("#login-password").attr("data-content", "<?php echo $password_err; ?>").popover("show");
    <?php } ?>
</script>

<?php mysqli_close($con); ?>