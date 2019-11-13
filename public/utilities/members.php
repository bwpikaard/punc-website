<?php
    require_once("../../resources/errors.php");
    session_start();
    require_once("../../handlers/members.php");
    require_once("../../handlers/users.php");
    require_once("../../handlers/authorization.php");
    
    if (isset($_GET["delete"])) {
        not_administrator();

        $id = $_GET["id"];

        $result = delete_member($id);

        header("Location: /admin#members");
    } else if (isset($_POST["register"])) {
        not_administrator();

        $name = $_POST["name"];
        $image = $_POST["image-name"];
        $website = $_POST["website"];
        $institution = $_POST["institution"];
        $institution_image = $_POST["institution-image-name"];
        $expertise = $_POST["expertise"];
        $instrumentation = $_POST["instrumentation"];
        $biography = $_POST["biography"];
        $approved = isset($_POST["approved"]) ? ($_POST["approved"] == "on" ? 1 : 0) : 0;
            
        $result = insert_member($name, $image, $website, $institution, $institution_image, $expertise, $instrumentation, $biography, $approved);

        if ($result) {
            header("Location: /admin#members");
        }
    } else if (isset($_POST["update"])) {
        echo "Update!";
        not_administrator();

        $id = $_POST["id"];
        $name = $_POST["name"];
        $image = $_POST["image-name"];
        $website = $_POST["website"];
        $institution = $_POST["institution"];
        $institution_image = $_POST["institution-image-name"];
        $expertise = $_POST["expertise"];
        $instrumentation = $_POST["instrumentation"];
        $biography = $_POST["biography"];
        $approved = isset($_POST["approved"]) ? ($_POST["approved"] == "on" ? 1 : 0) : 0;

        $result = update_member($id, $name, $image, $website, $institution, $institution_image, $expertise, $instrumentation, $biography, $approved);

        if ($result) {
            header("Location: /admin#members");
        } else {
            echo "No result?";
        }
    }