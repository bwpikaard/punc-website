<?php
    require_once("database.php");

    function select_member($id) {
        global $con;

        $stmt = "SELECT * FROM members WHERE id='$id'";
        $result = $con->query($stmt);

        return $result;
    }

    function select_members($approved) {
        global $con;

        if ($approved) {
            $stmt = "SELECT * FROM members WHERE approved='1'";
        } else {
            $stmt = "SELECT * FROM members";
        }

        $result = $con->query($stmt);

        return $result;
    }

    function insert_member($name, $image, $email, $website, $institution, $institution_image, $expertise, $instrumentation, $biography, $approved) {
        global $con;

        if (!isset($image)) $image = "";
        if (!isset($institution_image)) $institution_image = "";

        $stmt = $con->prepare("INSERT INTO members (name, image, email, website, institution, institution_image, expertise, instrumentation, biography, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssi", $name, $image, $email, $website, $institution, $institution_image, $expertise, $instrumentation, $biography, $approved);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_member($id, $name, $image, $email, $website, $institution, $institution_image, $expertise, $instrumentation, $biography, $approved) {
        global $con;
        
        $stmt = $con->prepare("UPDATE members SET name=?, image=?, email=?, website=?, institution=?, institution_image=?, expertise=?, instrumentation=?, biography=?, approved=? WHERE id='$id'");
        $stmt->bind_param("sssssssssi", $name, $image, $email, $website, $institution, $institution_image, $expertise, $instrumentation, $biography, $approved);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_member($id) {
        global $con;

        $stmt = "DELETE FROM members WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result;
    }
?>