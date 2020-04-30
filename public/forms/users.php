<?php
    session_start();

    require_once("../../resources/errors.php");
    require_once("../../app/authorization.php");
    require_once("../../app/users.php");

    $disabled = true;

    if (isset($_POST["login"])) {
        if (empty($_POST["username"])) {
            $error = urlencode("Please enter your email or username.");
            return header("Location: /login?ue=$error");
        } else if (empty($_POST["password"])) {
            $error = urlencode("Please enter your password.");
            return header("Location: /login?pe=$error");
        }
        
        $identifier = $_POST["username"];
        $users = select_user_by_identifier($identifier);

        if ($users->num_rows > 0) {
            $user = $users->fetch_assoc();

            if ($user["status"] < 1) {
                $error = urlencode("Your account is not activated.");
                return header("Location: /login?ue=$error&username=$username");
            }

            $hashed_password = $user["password"];

            if (password_verify($_POST["password"], $hashed_password)) {
                $_SESSION["user"] = $user;
                unset($_SESSION["user"]["password"]);

                $_SESSION["user"]["permissions"] = [];
                $permissions = select_user_permissions();

                while ($permission = $permissions->fetch_assoc()) {
                    if (!isset($_SESSION["user"]["permissions"][$permission["permission_module"]]))
                    $_SESSION["user"]["permissions"][$permission["permission_module"]] = [];
                    $_SESSION["user"]["permissions"][$permission["permission_module"]][] = $permission["permission_id"];
                }
                    
                header("Location: /me");
            } else {
                $error = urlencode("You entered an invalid password.");
                header("Location: /login?pe=$error&username=$username");
            }
        } else {
            $error = urlencode("No account was found with that email or username.");
            header("Location: /login?ue=$error&username=$username");
        }
    }