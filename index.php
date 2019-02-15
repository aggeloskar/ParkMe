<!DOCTYPE html>
<html lang="en">

<head>
    <title>ParkMe! | Find parking spots near you.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
        crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <link rel="stylesheet" type="text/css" href="styles/mobileStyle.css">
    <!--<script type="text/javascript" src="mapdata.js"></script>-->
    <script type="text/javascript" src="destination.js"></script>
    <script src="scripts/leaflet.ajax.min.js"></script>
 
  
</head>

<body>
   <nav class="navbar navbar-default">
      <div class="container-fluid">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="index.php"><img style="margin-top:-14px" src="images/logo.png" /></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
         <div id="accordion">
            <div class="card">
               <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                     <button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                     View City
                     </button>
                  </h5>
               </div>
               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                     <form role="form" action="runSingleSimulation.php" method="post" id="calculateDemand">
                     <div class="input-group">
                        <input id="timepicker" name="time" class="form-control timepicker">
                        <span class="input-group-btn">
                           <button type="button" onclick="timeSelect()" id="calculateDemand" class="btn btn-primary">Go!</button>
                        </span>
                     </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                     <button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     Find Parking
                     </button>
                  </h5>
               </div>
               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                  <div class="card-body">
                     <form role="form" action="findparking.php" method="post" id="findParking">
                        <div class="form-group">
                           <label for="clickedLocation">Select Location</label>
                           <input type="text" class="form-control" name="clickedLocation" id="clickedLocation" aria-describedby="locationHelp">
                           <small id="locationHelp" class="form-text text-muted">Click on map or insert coordinates</small>
                        </div>
                        <div class="form-group row">
                           <div class="col-xs-6">
                           <label for="time">Select Time</label>
                           <input type="text" name="time" class="form-control timepicker" id="time">
                        </div>
                        
                        <div class="col-xs-6">
                           <label for="radius">Select Radius</label>
                           <input type="text" class="form-control" name="radius" id="radius" value="50" pattern="([1-9]|[1-8][0-9]|9[0-9]|[1-4][0-9]{2}|500)" title="Distance in meters (1-500)" aria-describedby="radiusHelp">
                           <small id="radiusHelp" class="form-text text-muted">Select radius</small>
                        </div>
                        </div>
                        <button type="submit" id="form-submit" class="btn btn-primary">Submit</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </nav>
   <div id='map'></div>
   <script src="scripts/mobileMap.js"></script>
   <script src="scripts/mobileScripts.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

</body>

</html>