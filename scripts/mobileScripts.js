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
            alert("success");
        },
        error: function () {
            alert("failure");
        }
    });
    //DECOMMENT THIS:
    //event.preventDefault();
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