<?php
    function getConfiguration($key) {
        global $con;
        
        $query = "SELECT * FROM configuration WHERE `key`='$key'";

        $result = mysqli_query($con, $query);
        $value = mysqli_fetch_array($result);
        
        if ($result) {
            return $value['value'];
        } else {
            echo mysqli_error($con);
        }
    }
    
?>