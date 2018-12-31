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