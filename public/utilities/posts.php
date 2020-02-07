<?php
    require_once("../../resources/errors.php");
    session_start();
    require_once("../../handlers/posts.php");
    require_once("../../handlers/authorization.php");

    not_administrator();

    if (isset($_GET["delete"])) {
        $id = $_GET["id"];

        $result = delete_post($id);

        header("Location: /admin#posts");
    } else if (isset($_GET["publish"])) {
        $id = $_GET["id"];

        $result = publish_post($id, "1");

        header("Location: /admin#posts");
    } else if (isset($_GET["unpublish"])) {
        $id = $_GET["id"];

        $result = publish_post($id, "0");

        header("Location: /admin#posts");
    } else if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        
        $result = insert_post($author, $title, $content);
        
        if ($result) {
            header("Location: /admin#posts");
        }
    } else if (isset($_POST["register"])) {
        $author = $_SESSION["id"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        
        $result = insert_post($author, $title, $content);
        
        if ($result) {
            header("Location: /admin#posts");
        }
    }
?>