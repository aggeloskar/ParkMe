// Delete database AJAX
$("#deleteButton").click(function () {
  $.ajax({
    // URL where your PHP code is
    url: 'delete.php',
    method: "post",
    // if sent
    success: function (data) {
      alert('Database deleted succesfully!');
      $('#deleteModal').modal('hide');
      document.location.reload(true);
      mymap.removeLayer(graymap);
    }

  });
});

// Timepicker
var defaultTime = new Date().toLocaleTimeString();
$(document).ready(function () {
  $('.timepicker').timepicker({
    timeFormat: 'HH:mm ',
    interval: 60,
    minTime: '00:00',
    maxTime: '23.00 pm',
    defaultTime: defaultTime,
    startTime: '10:00',
    dynamic: false,
    dropdown: false,
    scrollbar: false
  });
});

// Add block info
$(document).ready(function () {
  $("#mapid").click(function () {
    $("#addBlock").submit(function (event) {
      var form = $(this);
      var url = form.attr('action');

      $.ajax({
        type: 'POST',
        url: 'addBlock.php',
        data: form.serialize(),
        // if sent
        success: function (data) {
          $("#blockAdded").html("Success");
        }
      });
      event.preventDefault();
    });
  });
});

//Calculate demand for given time
$("#calculateDemand2").submit(function (event) {
  var time = $("#timepicker2").val();
  var values = "time=" + time;

  $.ajax({
    type: "POST",
    url: "runSingleSimulation.php",
    data: values,
    // if sent
    success: function () {
      draw();
    },
    error: function () {
      alert("Something went wrong");
    }
  });
  event.preventDefault();
});


//Upload form AJAX
$("form#uploadForm").submit(function (e) {
  e.preventDefault();
  var formData = new FormData(this);

  $.ajax({
    url: 'upload.php',
    type: 'POST',
    data: formData,
    success: function (data) {
      alert(data);
      document.location.reload(true);
    },
    cache: false,
    contentType: false,
    processData: false
  });


});


// Add minutes to timepicker
$("#addMinute").click(function () {
  var mins = $("#manipulateMinutes").val();
  var timeString = $("#timepicker2").val();
  var timeSplit = timeString.split(':');
  var hours = parseInt(timeSplit[0]);
  var minutes = parseInt(timeSplit[1]) + parseInt(mins);
  hours += Math.floor(minutes / 60);
  while (hours >= 24) {
    hours -= 24;
  }
  minutes = minutes % 60;

  var time = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
  $("#timepicker2").val(time);


});

//TODO: Fix this
$("#removeMinute").click(function () {
  var mins = $("#manipulateMinutes").val();
  var timeString = $("#timepicker2").val();
  var timeSplit = timeString.split(':');
  var hours = parseInt(timeSplit[0]);
  var minutes = parseInt(timeSplit[1]);

  //convert to mins
  startTime = hours * 60 + minutes;
  endTime = startTime - mins;

  let h = Math.floor(endTime / 60);
  let m = endTime % 60;
  h = h < 10 ? '0' + h : h;
  m = m < 10 ? '0' + m : m;

  time = h + ':' + m;
  $("#timepicker2").val(time);
});