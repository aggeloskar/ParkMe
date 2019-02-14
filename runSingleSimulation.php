<?php
require 'connect.php';

echo("RUN SINGLE SIM");
// Demand Table
//array(time, center, home, constant)
$demandtable = array
(
  array(0, 0.75, 0.69, 0.18),
  array(1, 0.55, 0.71, 0.17),
  array(2, 0.46, 0.73, 0.21),
  array(3, 0.19, 0.68, 0.25),
  array(4, 0.2, 0.69, 0.22),
  array(5, 0.2, 0.7, 0.17),
  array(6, 0.39, 0.67, 0.16),
  array(7, 0.55, 0.55, 0.39),
  array(8, 0.67, 0.49, 0.54),
  array(9, 0.8, 0.43, 0.77),
  array(10, 0.95, 0.34, 0.78),
  array(11, 0.9, 0.45, 0.83),
  array(12, 0.95, 0.48, 0.78),
  array(13, 0.9, 0.53, 0.78),
  array(14, 0.88, 0.5, 0.8),
  array(15, 0.83, 0.56, 0.76),
  array(16, 0.7, 0.73, 0.78),
  array(17, 0.62, 0.41, 0.79),
  array(18, 0.74, 0.42, 0.84),
  array(19, 0.8, 0.48, 0.57),
  array(20, 0.8, 0.54, 0.38),
  array(21, 0.95, 0.6, 0.24),
  array(22, 0.92, 0.72, 0.19),
  array(23, 0.76, 0.66, 0.23)
);

unlink('mapdataonetime.js');

$time = $_POST['time'];
echo "Time posted is: " . $time;
$timeExploded = explode(":",$time);
$hour = $timeExploded[0];
$minutes = $timeExploded[1];

echo "<br>Time exploded is: " . $hour . " : " . $minutes;

if ($minutes>30){
    $hour++;
}

$time = intval($hour);
if (empty($time)){
    $time = intval(date("h")); //Set time as current time
}
echo $time;

echo "<br> Simulating for time: " . $time;

$sql = "SELECT gid, population, curve, spots FROM blocks";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $gid = $row["gid"];
        $population =  $row["population"];
        $curve =  $row["curve"];
        $spots =  $row["spots"];
        
        $demand = $population * 0.2 + $spots * $demandtable[$time][$curve];
        
        //DEBUG: if ($demand != 0) {echo "DEMAND=" . $demand . " Pop " . $spots;}
        $free_spots = $spots - ($demand * $spots / 100);
        //$demand = $demand * 100; //Set demand as a percentage

        // insert into database    
        $sql2 = "UPDATE blocks SET free_spots={$free_spots}, demand = {$demand} WHERE gid = {$gid}";
        // use exec() because no results are returned
        if (mysqli_query($conn, $sql2)) {
            //echo "ok\n";
        } else {
            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
        }
    
    }
    echo "calling mysqltojson...\n";
    mysqltojson($time, $conn);
    echo "mysqltojson done";
} else {
    echo "0 results";
}

function mysqltojson($time, $conn){
    $sql = "SELECT gid, population, demand, ST_AsGeoJSON(coordinates) FROM blocks";
    $result = mysqli_query($conn, $sql);

    //Initialize GeoJson
    $geojson = '{"type": "FeatureCollection","features": [' . $geojson;

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
        //echo "demand: " . $row["demand"]. " - gid: " . $row["gid"]. " " . $row["ST_AsGeoJSON(coordinates)"]. "<br>";
        $geojson = $geojson. '{"type": "Feature", "id": "' . $row["gid"] . '", "properties": {"demand": ' . $row["demand"] . ', "population": ' . $row["population"] . '}, "geometry": ';
        $geojson = $geojson . $row["ST_AsGeoJSON(coordinates)"] . '},';
        
        }
    } else {
        echo "0 results";
    }

    $geojson = rtrim($geojson,',');
    $geojson = $geojson . "]}" . PHP_EOL;
    echo $geojson . "<br>";
    $myfile = fopen("mapdataonetime.js", "a") or die("Unable to open file!");
    fwrite($myfile, $geojson);
    fclose($myfile);
}
mysqli_close($conn);
?>
  