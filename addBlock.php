<?php
    
    require 'connect.php';
    
    if($_POST['spots']){
        $spots = $_POST['spots'];
        $curve = $_POST['curve'];
        $gid = $_POST['gid'];
 
        // insert into database    
        $sql = "UPDATE blocks SET spots={$spots}, curve = {$curve} WHERE gid = {$gid}";
        // use exec() because no results are returned
        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
        }
  mysqli_close($conn);
?>