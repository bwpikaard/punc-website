<?php
    require_once("../../resources/errors.php");
    session_start();
    require_once("../../handlers/accounts.php");
    require_once("../../handlers/authorization.php");

    $disabled = true;

    if (isset($_POST["login"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        if (empty($username)) {
            $error = urlencode("Please enter your email or username.");
            header("Location: /login?ue=$error");
            exit;
        } else if (empty($password)) {
            $error = urlencode("Please enter your password.");
            header("Location: /login?pe=$error");
            exit;
        }
        
        $username = mysqli_real_escape_string($con, $username);
        $result = select_account($username);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($user["active"] == 0) {
                $error = urlencode("Your account is not activated.");
                return header("Location: /login?ue=$error&username=$username");
            }

            $hpassword = $user["password"];

            if (password_verify($password, $hpassword)) {
                $_SESSION["id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["administrator"] = $user["administrator"];
                $_SESSION["firstname"] = $user["firstname"];
                $_SESSION["lastname"] = $user["lastname"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["image"] = $user["image"];
                    
                header("Location: /me");
            } else {
                $error = urlencode("You entered an invalid password.");
                header("Location: /login?pe=$error&username=$username");
            }
        } else {
            $error = urlencode("No account was found with that email or username.");
            header("Location: /login?ue=$error&username=$username");
        }
    } else if (isset($_POST["register"])) {
        if (($disabled && !is_logged()) || !is_administrator()) {
            header("Location: /register?error=disabled");
            exit;
        }

        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $displayname = trim($_POST["displayname"]);
        $email = trim($_POST["email"]);

        if (empty($username)) {
            $error = urlencode("Please enter a email.");
            header("Location: /register?ue=$error");
            exit;
        } else if (empty($password)) {
            $error = urlencode("Please enter a password.");
            header("Location: /register?pe=$error");
            exit;
        } else if (strlen($password) < 6) {
            $error = urlencode("Password must have at least 6 characters.");
            header("Location: /register?pe=$error");
            exit;
        }

        $username = mysqli_real_escape_string($con, $username);
        $result = select_account($username);

        if ($result->num_rows > 0) {
            $error = urlencode("An account with that username or email already exists.");
            header("Location: /register?ue=$error");
            exit;
        }
        
        $hpassword = password_hash($password, PASSWORD_DEFAULT);

        $result = insert_account($username, $email, $displayname, $hpassword);

        if ($result) {
            if (isset($_POST["callback"])) {
                header("Location: " . $_POST["callback"]);
            } else {
                header("Location: /login?username=$username");
            }
        }
    } else if (isset($_POST["update"])) {
        not_logged();

        $id = $_POST["id"];

        if ($id !== $_SESSION["id"]) not_administrator();

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $website = $_POST["website"];
        $institution = $_POST["institution"];
        $expertise = $_POST["expertise"];
        $instrumentation = $_POST["instrumentation"];
        $biography = $_POST["biography"];

        $result = update_account($id, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography);

        header("Location: /me?id=$id");
    } else if (isset($_POST["update-admin"])) {
        not_administrator();

        $id = $_POST["id"];
        $type = $_POST["type"];
        $active = $_POST["active"];
        $username = $_POST["username"];
        $administrator = $_POST["administrator"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $website = $_POST["website"];
        $institution = $_POST["institution"];
        $expertise = $_POST["expertise"];
        $instrumentation = $_POST["instrumentation"];
        $biography = $_POST["biography"];

        $result = update_account_admin($id, $type, $active, $username, $administrator, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography);

        header("Location: /me?id=$id");
    } else if (isset($_POST["update-password"])) {
        not_administrator();

        $id = $_POST["id"];

        $password = trim($_POST["password"]);
        $hpassword = password_hash($password, PASSWORD_DEFAULT);

        $result = update_account_password($id, $hpassword);

        header("Location: /me?id=$id");
    } else if (isset($_GET["delete"])) {
        not_administrator();
        
        $id = $_GET["id"];

        $result = delete_account($id);

        header("Location: /admin#users");
    }
?>