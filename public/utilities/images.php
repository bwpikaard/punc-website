<?php
    session_start();
    require_once("../../handlers/authorization.php");

    function upload_image($name, $file_location) {
        if (!isset($_FILES[$name])) return "No Image";

        $file = $_FILES[$name];
        $file_ext = strtolower(end(explode('.', $file['name'])));

        if (!in_array($file_ext, array('png', 'jpg', 'jpeg'))) return "InvalidExtension";
        if ($file['error'] !== 0) return "FileError: Error #{$file['error']}";
        if ($file['size'] > 15 * 1024 * 1024) return "FileTooLarge";

        if (!move_uploaded_file($file['tmp_name'], "../assets/images/$file_location/{$file['name']}")) return "ServerError";

        return $file['name'];
    }

    if (isset($_POST["upload"])) {
        not_administrator();

        if (!isset($_FILES["file"])) return header("Location: /admin#images?error=NoImage");

        $file = $_FILES['file'];
        $file_ext = strtolower(end(explode('.', $file['name'])));

        if (!in_array($file_ext, array('png', 'jpg', 'jpeg'))) return header("Location: /admin#images?error=InvalidExtension");
        if ($file['error'] !== 0) return header("Location: /admin#images?error=FileError&err={$file['error']}");
        if ($file['size'] > 15 * 1024 * 1024) return header("Location: /admin#images?error=FileTooLarge");

        $file_name = $_POST["name"];
        $file_location = $_POST["location"];
        
        if (!move_uploaded_file($file['tmp_name'], "../assets/images/$file_location/$file_name.$file_ext")) return header("Location: /admin#images?error=ServerError");
        
        header("Location: /admin#images");
    } else if (isset($_GET["delete"])) {
        not_administrator();
        
        $file_name = $_GET["name"];
        $file_location = $_GET["location"];
        
        if (file_exists("../assets/images/$file_location/$file_name"))
            if (!unlink("../assets/images/$file_location/$file_name")) return header("Location: /?error=ServerError");
        else {
            header("Location: /?exists=false");
        }

        header("Location: /admin#images");
    }
?>