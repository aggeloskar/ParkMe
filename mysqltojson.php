<?php
require("connect.php");

$sql = "SELECT gid, population, demand, ST_AsGeoJSON(coordinates) FROM blocks";
$result = mysqli_query($conn, $sql);

//Initialize GeoJson
$geojson = 'var mapdata = {"type": "FeatureCollection","features": [' . $geojson;

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      //echo "Population: " . $row["population"]. " - gid: " . $row["gid"]. " " . $row["ST_AsGeoJSON(coordinates)"]. "<br>";
      $geojson = $geojson. '{"type": "Feature", "id": "' . $row["gid"] . '", "properties": {"demand": ' . $row["demand"] . ', "population": ' . $row["population"] . '}, "geometry": ';
      $geojson = $geojson . $row["ST_AsGeoJSON(coordinates)"] . '},';
      
    }
} else {
    echo "0 results";
}

$geojson = rtrim($geojson,',');
$geojson = $geojson . "]}";
echo $geojson . "<br>";
$myfile = fopen("mapdata.js", "w") or die("Unable to open file!");
fwrite($myfile, $geojson);
fclose($myfile);

mysqli_close($conn);
?>