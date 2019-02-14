$("#deleteButton").click(function () {
  $.ajax({
    // URL where your PHP code is
    url: 'delete.php',
    method: "post",
    // if sent
    success: function (data) {
      alert('Database deleted succesfully!');
      $('#deleteModal').modal('hide');
    }

  });
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
    dropdown: true,
    scrollbar: true
  });
});

/*
$("#calculateDemand").click(function () {

  $.ajax({
    // URL where your PHP code is
    url: 'calculatedemand.php',
    method: "post",
    // if sent
    success: function (data) {
      //TODO: Dynamically refresh map

      alert('Success!');
      console.log('Calculated demand');
    }

  });
});
*/


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
          //TODO: Dynamically refresh map
          //TODO: Fix messages appearing multiple times
          //alert("Block added");
          $("#blockAdded").html("Success");
        }
      });
      event.preventDefault();
    });
  });
});

$("#calculateDemand").submit(function (event) {
  var time = $("#timepicker").val();
  var values = "time=" + time;

  $.ajax({
    type: "POST",
    url: "calculatedemand.php",
    data: values,
    // if sent
    success: function () {
      //alert("Success!");
      location.reload(true);
    },
    error: function () {
      alert("Something went wrong");
    }
  });
  //DECOMMENT THIS:
  event.preventDefault();
});


//TODO: FIX THIS UPLOAD FORM
$(document).ready(function () {
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

  })
});

$("#startSimulation").click(function () {
  alert("This will take a while");
  $.ajax({
    // URL where your PHP code is
    url: 'runSimulation.php',
    method: "post",
    // if sent
    success: function (data) {
      alert('Simulation completed succesfully!'); 
      location.reload(true);   
    }

  });
});

$("#resetSimulation").click(function () {
  $.ajax({
    // URL where your PHP code is
    url: 'resetSimulation.php',
    method: "post",
    // if sent
    success: function (data) {
      alert('Simulation reseted succesfully!'); 
    }

  });
});

$("#addMinute").click(function(){
  var mins = $("#manipulateMinutes").val();
  var timeString = $("#timepicker").val();
  var timeSplit = timeString.split(':');
  var hours = parseInt(timeSplit[0]);
  var minutes = parseInt(timeSplit[1]) + parseInt(mins);
  hours += Math.floor(minutes / 60);
  while (hours >= 24) {
    hours -= 24;
  }
  minutes = minutes % 60;
  
  var time = ('0' + hours).slice(-2) + ':' + ('0' +minutes).slice(-2);
  $("#timepicker").val(time);
  

});

/*================================TODO: FIX THIS -- REMOVEs MINUTES FROM FORM=============================*/
$("#removeMinute").click(function(){
  var mins = $("#manipulateMinutes").val();
  var timeString = $("#timepicker").val();
  var timeSplit = timeString.split(':');
  var hours = parseInt(timeSplit[0]);
  var minutes = parseInt(timeSplit[1]) - parseInt(mins);
  hours += Math.floor(minutes / 60);
  while (hours <= 0) {
    hours -= 24;
  }
  minutes = minutes % 60;
  
  var time = ('0' + hours).slice(-2) + ':' + ('0' +minutes).slice(-2);
  $("#timepicker").val(time);
});