<?php
  require 'connect.php';

  $kml = simplexml_load_file("data.kml");
  foreach ($kml->Document->Folder->Placemark as $pm) {
    $description = $pm->description;
    
    // explode the data from kml file
    $explodedData = explode("\n", $description);
    // remove non-numbers
    $gid = preg_replace('/[^0-9.]+/', '', $explodedData[4]);
    $esye_code = preg_replace('/[^0-9.]+/', '', $explodedData[5]);
    $population = preg_replace('/[^0-9.]+/', '', $explodedData[6]);
    $coordinates = $pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;
    if($population == '') {
      $population = 0;
    }
    
    //Convert coordinates to mysql wkt polygon notaion
    $coordinates = str_replace(',', '_', $coordinates);
    $coordinates = str_replace(' ', ',', $coordinates);
    $coordinates = str_replace('_', ' ', $coordinates);
    
    $coordinates = "POLYGON((" . $coordinates;
    $coordinates = $coordinates . "))";

    // print the kml file for debug
    // echo $gid, $esye_code, $population, $pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates, PHP_EOL;
    
    // insert into database    
    $sql = "INSERT INTO blocks (gid, esye_code, population, coordinates)
    VALUES ('{$gid}', '{$esye_code}', '{$population}', PolygonFromText('{$coordinates}'))";
    // use exec() because no results are returned
    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
 }
 mysqli_close($conn);
 
?>