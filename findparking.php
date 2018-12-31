<?php
/*TODO:
**Get radius from user with POST
**Find all ID with centroid inside radius
**Create #free_spots 50m around centroids
**Call DBSCAN
*/

require 'connect.php';
require_once('dbscan.php');

$destination = $_POST["clickedLocation"]; //Coordinates from user
$time = $_POST['time']; //Time from user
$max_radius = $_POST['radius'];

//TODO: FIRST RUN CALCULATION BEFORE CALCULATING PARKING

$destination = preg_replace("/[^0-9,.]/", "", $destination);
$latlng = explode(",", $destination);
$lat = $latlng[0];
$lng = $latlng[1];

$destination_wkt = "POINT(" . $lng . "," . $lat . ")";

/*DEBUG
echo 'Post Data: <br>';
echo 'Destination ' . $destination;
echo '<br>Lat: ' . $lat;
echo '<br>Lng: ' . $lng;
echo '<br>Time: ' . $time;
echo '<br>Max radius:' . $max_radius;
echo '<br>============================<br>';
*/

$sql = "SELECT gid,ST_asText(ST_Centroid(coordinates)), free_spots FROM `blocks` WHERE st_distance_sphere(ST_Centroid(coordinates), {$destination_wkt}) <= {$max_radius}";
$result = mysqli_query($conn, $sql);

$points_array = array();
//echo 'SQL results: <br>';
if (mysqli_num_rows($result) > 0) {
    // Manipulate data for each row
    while($row = mysqli_fetch_assoc($result)) {
        //echo "gid: " . $row["gid"]. " - Coords: " . $row["ST_asText(ST_Centroid(coordinates))"]. " " . $row["free_spots"]. "<br>";
        //echo 'Random coordinates around block ' . $row["gid"] . ': <br>';
        
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

            //echo 'Random point #' .$i. ': ' . $lng_min . ', ' . $lat_min . '<br>';
            //echo 'Coords max: ' . $lng_max . ', ' . $lat_max . '<br>';
            //END RANDOM POINT CREATOR
            //$points_array[$row["gid"]][] = $lng_min . ", " . $lat_min; //FOR ASOC ARRAY
            $points_array[] = $lng_min . ", " . $lat_min;
        }
        
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
//echo "<br>END OF SQL ESUTLS <br> ================== <br>";

$spots = count($points_array);
//echo "<br>Spots: " . $spots ;

$distance_matrix = array();
for ($i=0; $i<=$spots; $i++){
    for ($j=$i+1; $j<$spots; $j++){
        $distance_matrix[$i][$j] = findDistance($points_array[$i],$points_array[$j]);
    }  
}

$point_ids = range(0,$spots);

//echo 'Point IDs:<br />';
//print_r($point_ids);
// Setup DBSCAN with distance matrix and unique point IDs
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
//TODO: HANDLE MORE THAN ONE MAX CLUSTER
echo "<br>Biggest cluster: " . $maxIndex . " with " . $maxPoints . " points.";
echo "<br>";


for ($i = 0; $i <$maxPoints; $i++){
    //COORDINATES OF MAX CLUSTER:
    echo $points_array[$clusters[$maxIndex][$i]] . "<br>";
}
//TODO: FIND CENTER OF COORDINATES
$centerOfCluster = "40.633928263832, 22.956431981203";
//TODO: CREATE GEOJSON
//TODO: APPEAR ON MAP

/*
echo "<pre>";
print_r($clusters[$maxIndex]);
echo "</pre>";

echo "<pre>";
print_r($points_array);
echo "</pre>";

echo "<pre>";
print_r($distance_matrix);
echo "</pre>";

echo "<pre>";
print_r($point_ids);
echo "</pre>";
*/




function findDistance($x, $y) {
    $latlonFrom = explode(",", $x);
    $latFrom = $latlonFrom[0];
    $lonFrom = $latlonFrom[1];
    //echo $latFrom . $lonFrom;

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
    //echo "Distance from " . $x . " to " . $y . " is: ". $meters . " meters<br>";
}

?>