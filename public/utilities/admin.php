<?php
    require_once("../../app/members.php");
    require_once("../../app/users.php");

    if (isset($_GET["delete-member"])) {
        $id = $_GET["id"];

        $query = "DELETE FROM `members` WHERE id=$id";

        $result = mysqli_query($con, $query);
                    
        if ($result) {
            header("Location: /admin");
        } else {
            echo mysqli_error($con);
        }
    } else if (isset($_GET["delete-user"])) {
        $id = $_GET["id"];

        $query = "DELETE FROM `users` WHERE id=$id";

        $result = mysqli_query($con, $query);
                        
        if ($result) {
            header("Location: /admin");
        } else {
            echo mysqli_error($con);
        }
    } else if (isset($_POST["add-member"])) {
        $name = $_POST["name"];
        $image = $_POST["image"];
        $website = $_POST["website"];
        $institution = $_POST["institution"];
        $institution_image = $_POST["institution_image"];
        $expertise = $_POST["expertise"];
        $instrumentation = mysqli_real_escape_string($con, $_POST["instrumentation"]);
        $biography = mysqli_real_escape_string($con, $_POST["biography"]);
            
        $query = "INSERT into members (name, image, website, institution, institution_image, expertise, instrumentation, biography) VALUES ('$name', '$image', '$website', '$institution', '$institution_image', '$expertise', '$instrumentation', '$biography')";

        $result = mysqli_query($con, $query);
                    
        if ($result) {
            header("Location: /admin");
        } else {
            echo mysqli_error($con);
        }
    } else if (isset($_POST["update-member"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $image = $_POST["image"];
        $website = $_POST["website"];
        $institution = $_POST["institution"];
        $institution_image = $_POST["institution_image"];
        $expertise = $_POST["expertise"];
        $instrumentation = mysqli_real_escape_string($con, $_POST["instrumentation"]);
        $biography = mysqli_real_escape_string($con, $_POST["biography"]);

        $query = "UPDATE members SET name='$name', image='$image', website='$website', institution='$institution', institution_image='$institution_image', expertise='$expertise', instrumentation='$instrumentation', biography='$biography' WHERE id=$id";

        $result = mysqli_query($con, $query);
                
        if ($result) {
            header("Location: /admin");
        } else {
            echo mysqli_error($con);
        }
    } else if (isset($_POST["add-user"])) {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $displayname = trim($_POST["displayname"]);
        $password = trim($_POST["password"]);

        if (empty($username)) $username_err = "Please enter a email.";
        else if (empty($password)) $password_err = "Please enter a password.";
        else if (strlen($password) < 6) $password_err = "Password must have at least 6 characters.";

        if (empty($username_err) && empty($password_err)) {
            $username = mysqli_real_escape_string($con, $username);
            $email = mysqli_real_escape_string($con, $email);
            $displayname = mysqli_real_escape_string($con, $displayname);
            $user_stmt = "SELECT * FROM users WHERE username='$username'";
            $user_result = mysqli_query($con, $user_stmt);
            $user = mysqli_fetch_array($user_result);

            if ($user) {
                $username_err = "An account with that email already exists.";
            } else {
                $hpassword = mysqli_real_escape_string($con, password_hash($password, PASSWORD_DEFAULT));
                $created = date("Y-m-d H:i:s");

                $create_stmt = "INSERT INTO users (username, email, displayname, password, administrator, created) VALUES ('$username', '$email', '$displayname', '$hpassword', '0', '$created')";
                $create_result = mysqli_query($con, $create_stmt);

                if ($create_result) {
                    header("Location: /admin");
                } else {
                    echo mysqli_error($con);
                }
            }
        }
    } else if (isset($_POST["update-user"])) {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $displayname = $_POST["displayname"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $administrator = ($_POST["administrator"] == "on" ? 1 : 0);

        $query = ($password ?
            "UPDATE users SET username='$username', email='$email', displayname='$displayname', password='$hashed_password', administrator='$administrator' WHERE id=$id"
            :
            "UPDATE users SET username='$username', email='$email', displayname='$displayname', administrator='$administrator' WHERE id=$id"
        );

        $result = mysqli_query($con, $query);
                
        if ($result) {
            header("Location: /admin");
        } else {
            echo mysqli_error($con);
        }
    }
?>