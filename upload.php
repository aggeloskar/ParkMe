<?php
//uploads file to root directory and parses is it with myparser.php
$target_dir = "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow kml file formats
if($FileType != "kml") {
    echo "Sorry, only KML files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload and parse file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'data.kml')) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        //parse
        require 'myparser.php';
        //delete uploaded file
        unlink('data.kml');
        require('calculatedemand.php');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>