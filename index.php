<?php
require 'connect.php';
include('session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>ParkMe | Administrator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="styles/style.css">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
  
  <script type="text/javascript" src="simpledata.js"></script>
  
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php"><img style="margin-top:-14px" src="images/logo.png" /></a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage City</a></li>
        <!--<li><a href="blocks.php">Manage blocks</a></li>-->
        <li><a href="simulation.php">Start simulation</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
      <p class="navbar-text navbar-right">Logged in as:</p>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row content" style="background-color: #d5d5d5">
      <div class="col-sm-3">
        <h2>Welcome!</h2>
        <p>ParkMe is a parking simulation website for your Smart City!</p>
        <p>Choose your action from the top menu.</p>
        <hr/>
        <h4>Help</h4>
        <p> To manage database and add block information, choose "Manage City". </p>
        <p> Choose "Start Simulation", to view parking availability. </p>
      </div>

      <div id="map-container" class="col-sm-9" style="margin-left: -15px">
        <div id="mapid"></div>
      </div>
    </div>
  </div>

  <footer class="container-fluid">
    <!-- Footer -->
    <div class="footer-copyright text-center py-3">© Copyright 2018 |
      <a href="mobile.php"> Go to mobile site</a>
    </div>
    <!-- Footer -->
  </footer>
  
  <script src="scripts/scripts.js"></script>
  <script src="scripts/indexMap.js"></script>

</body>

</html>