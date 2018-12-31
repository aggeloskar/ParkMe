$("#deleteButton").click(function () {
  $.ajax({
    // URL where your PHP code is
    url: 'delete.php',
    method: "post",
    // if sent
    success: function (data) {
      alert('Database deleted succesfully!');
      console.log('delete ok');
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
  alert(time);
  var values = "time=" + time;

  $.ajax({
      type: "POST",
      url: "calculateDemand.php",
      data: values,
      // if sent
      success: function () {
          //alert("success");
      },
      error: function () {
          //alert("failure");
      }
  });
  //DECOMMENT THIS:
  //event.preventDefault();
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