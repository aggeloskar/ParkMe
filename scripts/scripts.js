// Delete database. OK
$("#deleteButton").click(function () {
  $.ajax({
    // URL where your PHP code is
    url: 'delete.php',
    method: "post",
    // if sent
    success: function (data) {
      alert('Database deleted succesfully!');
      resetmap();
      $('#deleteModal').modal('hide');
    }

  });
});

// Timepicker. OK
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

// Add block info and print success. OK
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

//calculateDemand OK.
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


//TODO: FIX THIS UPLOAD FORM
$("#uploadForm").submit(function (event) {

  $.ajax({
    type: "POST",
    url: "upload.php",
    data: new FormData(this),
    // if sent
    success: function () {
      alert("success");
    },
    error: function () {
      alert("failure");
    }
  });
  //DECOMMENT THIS:
  event.preventDefault();

});


// Add minutes to timepicker. OK
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

//Not so OK.
$("#removeMinute").click(function () {
  var mins = $("#manipulateMinutes").val();
  var timeString = $("#timepicker2").val();
  var timeSplit = timeString.split(':');
  var hours = parseInt(timeSplit[0]);
  var minutes = parseInt(timeSplit[1]) - parseInt(mins);
  hours += Math.floor(minutes / 60);
  while (hours <= 0) {
    hours -= 24;
  }
  minutes = minutes % 60;

  var time = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
  $("#timepicker2").val(time);
});

//TODO
//ONCLICK Start Simulation -> start simulation on current time