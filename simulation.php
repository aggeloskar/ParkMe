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
  <script src="scripts/leaflet.ajax.min.js"></script>
  <!--<script type="text/javascript" src="mapdata.js"></script>-->
  <script type="text/javascript" src="simpledata.js"></script>
  

</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="admin.php"><img style="margin-top:-14px" src="images/logo.png" /></a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="admin.php">Home</a></li>
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
        <br>
        <div>
        <label for="time">Select Time:</label>
        <div class="input-group">
        <form role="form" action="runSingleSimulation.php" method="post" id="calculateDemand2">
          <input size="36" autocomplete="off" id="timepicker2" name="time" class="timepicker">
          <button type="submit" id="calculateDemand2" class="btn btn-primary btn-block">Start Simulation</button>
        </form>
        </div>
        <br>
        <label for="time">Change minutes:</label>
        <div class="input-group">
        <span class="input-group-btn">
            <button type="button" onclick="timeSelect()" id="removeMinute" class="btn btn-primary">-</button>
          </span>
          <input id="manipulateMinutes" name="minutes" class="form-control" value="30" pattern="[1-5]?[0-9]" title="Number 1-59">
          <span class="input-group-btn">
            <button type="button" onclick="timeSelect()" id="addMinute" class="btn btn-primary">+</button>
          </span>
        </div>
        
        </div>
       
        
        <!--<div>
        <hr/>
        If a new kml file is uploaded, select "Start Simulation". This may take a while.
        </div>
        <div>
        <button type="button" id="startSimulation" class="btn btn-primary btn-block">Start Simulation</button>
        
        <br>
        
        <button type="button" id="resetSimulation"class="btn btn-primary btn-block">Reset Simulation</button>
        </div>
        <br>-->
      </div>

      <div id="map-container" class="col-sm-9" style="margin-left: -15px">
        <div id="mapid"></div>
      </div>
    </div>
  </div>
  
  <footer class="container-fluid">
    <!-- Footer -->
    <div class="footer-copyright text-center py-3">© Copyright 2018 |
      <a href="index.php"> Go to mobile site</a>
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