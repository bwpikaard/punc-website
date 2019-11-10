<?php
    require_once("../../app/members.php");
    require_once("../../app/users.php");

    if (isset($_GET["delete-member"])) {
        $id = $_GET["id"];

        $result = delete_member($id);

        header("Location: /admin#members");
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
    }
?>