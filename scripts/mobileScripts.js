$("#findParking").submit(function (event) {
  var clickedLocation = $("#clickedLocation").val();
  var time = $("#time").val();
  var radius = $("#radius").val();
  var values = "clickedLocation=" + clickedLocation + "&time=" + time + "&radius=" + radius;

  $.ajax({
    type: "POST",
    url: "findparking.php",
    data: values,
    // if sent
    success: function () {
      drawMap();
      draw();
    },
    error: function () {
      alert("Something went wrong! Please try again!");
    }
  });
  event.preventDefault();
});

$(document).ready(function () {
  $('.timepicker').timepicker({
    timeFormat: 'HH:mm ',
    interval: 60,
    minTime: '00:00',
    maxTime: '23.00 pm',
    defaultTime: '11',
    startTime: '10:00',
    dynamic: false,
    dropdown: false,
    scrollbar: false
  });
});

$("#calculateDemand").submit(function (event) {
  var time = $("#timepicker").val();
  var values = "time=" + time;

  $.ajax({
    type: "POST",
    url: "runSingleSimulation.php",
    data: values,
    // if sent
    success: function () {
      alert("Success!");
    },
    error: function () {
      alert("Something went wrong");
    }
  });
  //DECOMMENT THIS:
  event.preventDefault();
});

$(document).ready(function () {
  $.ajax({
    url: "runSingleSimulation.php",
    success: function () {
      drawMap();
    },
    error: function () {
      console.log("Error running simulation");
    }
  });
});