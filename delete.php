<?php

require 'connect.php';

// sql to delete a record
    $sql = "TRUNCATE TABLE blocks;";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    unlink('mapdata.js');

    mysqli_close($conn);
    header("Location: manage.php");
    die();
?>
