<?php
    session_start();
    require_once("../../app/users.php");

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
        $result = select_user($username);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $hpassword = $user["password"];

            if (password_verify($password, $hpassword)) {
                $_SESSION["id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["displayname"] = $user["displayname"];
                $_SESSION["administrator"] = $user["administrator"];
                    
                header("Location: /admin");
            } else {
                $error = urlencode("You entered an invalid password.");
                header("Location: /login?pe=$error");
            }
        } else {
            $error = urlencode("No account was found with that email or username.");
            header("Location: /login?ue=$error");
        }
    } else if (isset($_POST["register"])) {
        if ($disabled) {
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
        $result = select_user($username);

        if ($result->num_rows > 0) {
            $error = urlencode("An account with that username or email already exists.");
            header("Location: /register?ue=$error");
            exit;
        }
        
        $hpassword = mysqli_real_escape_string($con, password_hash($password, PASSWORD_DEFAULT));

        $result = insert_user($username, $email, $displayname, $hpassword);

        if ($result) {
            if ($_POST["return"]) {
                header("Location: " . $_POST["return"]);
            } else {
                header("Location: /login?username=$username");
            }
        }
    }
?>