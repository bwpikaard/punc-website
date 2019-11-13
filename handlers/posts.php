<?php
    require_once("database.php");

    function select_author($id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    function select_post($id) {
        global $con;

        $stmt = "SELECT * FROM posts WHERE id='$id'";
        $result = $con->query($stmt);

        return $result->get_results()->fetch_assoc();
    }

    function select_posts($published) {
        global $con;

        if ($published) {
            $stmt = "SELECT * FROM posts WHERE published='1'";
        } else {
            $stmt = "SELECT * FROM posts";
        }

        $result = $con->query($stmt);

        return $result;
    }

    function insert_post($author, $title, $content) {
        global $con;
        
        $created = date("Y-m-d H:i:s");

        $stmt = $con->prepare("INSERT INTO posts (published, author, title, content, created) VALUES ('0', ?, ?, ?, '$created')");
        $stmt->bind_param("sss", $author, $title, $content);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_post($id, $title, $content) {
        global $con;
        
        $modified = date("Y-m-d H:i:s");

        $stmt = $con->prepare("UPDATE posts SET title=?, content=?, modified='$modified' WHERE id='$id'");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_post($id) {
        global $con;

        $stmt = "DELETE FROM posts WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result;
    }

    function publish_post($id, $published) {
        global $con;

        $stmt = "UPDATE posts SET published='$published' WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result;
    }
?>