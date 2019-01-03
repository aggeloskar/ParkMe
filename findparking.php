<?php

require 'connect.php';
require_once('dbscan.php');

$destination = $_POST["clickedLocation"];
$time = $_POST['time'];
$max_radius = $_POST['radius'];

//================================TODO: FIRST RUN CALCULATION BEFORE CALCULATING PARKING ====================================

$destination = preg_replace("/[^0-9,.]/", "", $destination);
$latlng = explode(",", $destination);
$lat = $latlng[0];
$lng = $latlng[1];

$destination_wkt = "POINT(" . $lng . "," . $lat . ")";

$sql = "SELECT gid,ST_asText(ST_Centroid(coordinates)), free_spots FROM `blocks` WHERE st_distance_sphere(ST_Centroid(coordinates), {$destination_wkt}) <= {$max_radius}";
$result = mysqli_query($conn, $sql);

$points_array = array();
if (mysqli_num_rows($result) > 0) {
    // Manipulate data for each row
    while($row = mysqli_fetch_assoc($result)) {
        $coords = preg_replace("/[^0-9,. ]/", "", $row["ST_asText(ST_Centroid(coordinates))"]);
        $latlng = explode(" ", $coords);
        $latitude = $latlng[0];
        $longitude = $latlng[1];
                 
        for ($i = 1; $i<=$row["free_spots"]; $i++){
            //CREATE RANDOM POINTS FOR EACH FREE SPOT AROUND CENTROID
            
            $radius = rand(1,50); // in miles
            $radius = $radius * 0.000621371192; //converted to km

            $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
            $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
            $lat_min = $latitude - ($radius / 69);
            $lat_max = $latitude + ($radius / 69);
            $points_array[] = $lng_min . ", " . $lat_min;
        }        
    }
} else {
    echo "0 results";
}

mysqli_close($conn);

$spots = count($points_array);

$distance_matrix = array();
for ($i=0; $i<=$spots; $i++){
    for ($j=$i+1; $j<$spots; $j++){
        $distance_matrix[$i][$j] = findDistance($points_array[$i],$points_array[$j]);
    }  
}

$point_ids = range(0,$spots);

$DBSCAN = new DBSCAN($distance_matrix, $point_ids);
$epsilon = 20;
$minpoints = 13;
// Perform DBSCAN clustering
$clusters = $DBSCAN->dbscan($epsilon, $minpoints);
//Output results
echo '<br>Clusters (using epsilon = ' . $epsilon .  ' and minpoints = ' . $minpoints . '): <br /><br />';
$maxPoints = 0;
$maxIndex = 0;
foreach ($clusters as $index => $cluster)
{
	if (sizeof($cluster) > 0)
	{
		echo 'Cluster number '.($index+1).':<br />';
        echo '<ul>';
        $numOfPoints = count($cluster);
        
        if( $numOfPoints > $maxPoints){
            $maxIndex = $index;
            $maxPoints = $numOfPoints;
        }
        echo 'Number of points in cluster: ' . $numOfPoints;
		foreach ($cluster as $member_point_id)
		{
			echo '<li>'.$member_point_id.'</li>';
		}
		echo '</ul>';
	}
}
//===========================TODO: HANDLE MORE THAN ONE MAX CLUSTER=========================================
echo "<br>Biggest cluster: " . $maxIndex . " with " . $maxPoints . " points.";
echo "<br>";

$polygonarray = [];

for ($i = 0; $i <$maxPoints; $i++){
    //COORDINATES OF MAX CLUSTER:
    $polygonarray[] = explode(", ", $points_array[$clusters[$maxIndex][$i]]);
}

$centerofpoints = GetCenterFromDegrees($polygonarray);
$centerlat = $centerofpoints[0];
$centerlon = $centerofpoints[1];
echo $centerlat . $centerlon;

geoJSON($lat, $lng, $centerlat, $centerlon);


function findDistance($x, $y) {
    $latlonFrom = explode(",", $x);
    $latFrom = $latlonFrom[0];
    $lonFrom = $latlonFrom[1];
    
    $latlonTo = explode(",", $y);
    $latTo = $latlonTo[0];
    $lonTo = $latlonTo[1];

    $theta = $lonFrom - $lonTo;
    $dist = sin(deg2rad($latFrom)) * sin(deg2rad($latTo)) +  cos(deg2rad($latFrom)) * cos(deg2rad($latTo)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $meters = $miles * 1609.344;
    return $meters;
}

function GetCenterFromDegrees($data)
{
    if (!is_array($data)) return FALSE;

    $num_coords = count($data);

    $X = 0.0;
    $Y = 0.0;
    $Z = 0.0;

    foreach ($data as $coord)
    {
        $lat = $coord[0] * pi() / 180;
        $lon = $coord[1] * pi() / 180;

        $a = cos($lat) * cos($lon);
        $b = cos($lat) * sin($lon);
        $c = sin($lat);

        $X += $a;
        $Y += $b;
        $Z += $c;
    }

    $X /= $num_coords;
    $Y /= $num_coords;
    $Z /= $num_coords;

    $lon = atan2($Y, $X);
    $hyp = sqrt($X * $X + $Y * $Y);
    $lat = atan2($Z, $hyp);

    return array($lat * 180 / pi(), $lon * 180 / pi());
}

function geoJSON($lat, $lng, $centerlat, $centerlon){
    $json = 'var destination = {
        "type": "FeatureCollection",
        "features": [
          {
            "type": "Feature",
            "properties": {},
            "geometry": {
              "type": "Point",
              "coordinates": [' . $lng . ', '. $lat . ']
            }
          },
          {
            "type": "Feature",
            "properties": {},
            "geometry": {
              "type": "Point",
              "coordinates": [' . $centerlon . ', ' . $centerlat . ']
            }
          },
          {
            "type": "Feature",
            "properties": {},
            "geometry": {
              "type": "LineString",
              "coordinates": [
                [' . $lng . ', ' . $lat . '],
                [' . $centerlon . ', ' . $centerlat . ']
                ]
              }
            }
          ]
        }';

    $myfile = fopen("destination.js", "w") or die("Unable to open file!");
    fwrite($myfile, $json);
    fclose($myfile);
}

?>