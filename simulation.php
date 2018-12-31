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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

  <script type="text/javascript" src="mapdata.js"></script>
  

</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php"><img style="margin-top:-14px" src="images/logo.png" /></a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage City</a></li>
        <!--<li><a href="blocks.php">Manage blocks</a></li>-->
        <li class="active"><a href="simulation.php">Start simulation</a></li>
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
      <div class="col-sm-3 ">

        <h2>Actions</h2>
        <div>
        <form role="form" action="calculatedemand.php" method="post" id="calculateDemand">
          Select time:
          <input size="36" id="timepicker" name="time" class="timepicker">
          <button type="submit" id="calculateDemand" class="btn btn-primary btn-block">Start Simulation</button>
          </form>
        </div>
        
        <hr/>
        <button type="button" class="btn btn-primary btn-block" disabled>Reset Simulation</button>
        
        <br>
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
  <div id="loading" class="loading">
    <img src="images/loading.gif" /> 
  </div>
  <script src="scripts/scripts.js"></script>
  <script src="scripts/loader.js"></script>
  <script src="scripts/simulateMap.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>

</html>