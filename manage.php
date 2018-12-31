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
        <li class="active"><a href="manage.php">Manage City</a></li>
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
      <div class="col-sm-3 ">
        
        <h3>Manage Database</h3>
        <p>Upload a kml file to the database. If database is not empty, first delete it.</p>
        <?php
        $query = "SELECT gid FROM blocks";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
         
        if($count == 0) {
            echo '<p style="font-size:80%; text-align:right;">Current database status: Empty</p>';
        } else {
            echo '<p style="font-size:80%; text-align:right;">Current database status: Not empty</p>';
        }
        ?>
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#uploadModal">Upload</button>

        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#deleteModal">Delete</button>
        <hr />
        <h3>Manage blocks</h3>
        <p>To add information about a block, click on it on the map.</p>
              
        <!-- Upload Modal -->
        <div class="modal fade" id="uploadModal" role="dialog">
          <div class="modal-dialog">

            <!-- Upload Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select file to upload</h4>
              </div>
              <div class="modal-body">
                <form action="upload.php" id="uploadForm" method="POST" enctype="multipart/form-data">
                  Select a file: <input type="file" name="fileToUpload"><br><br>
                  <input type="submit">
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
         <!-- Delete Modal -->
         <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog">
  
              <!-- Delete Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="modal-title">Warning</h3>
                </div>
                <div class="modal-body">
                  <h4>Are you sure you want to delete? This action cannot be undone.</h4>
                  <button id="deleteButton" class="btn btn-danger">Delete</button>
                  <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
  
            </div>
          </div>
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

  <script src="scripts/scripts.js"></script>
  <script src="scripts/manageMap.js"></script>
  
</body>

</html>