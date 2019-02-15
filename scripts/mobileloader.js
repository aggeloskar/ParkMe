var $loading = $('#loading').hide();

$(document)
  .ajaxStart(function () {
    //ajax request went so show the loading image
    $('#loading').show();
    //$('#map').hide();
    $("#map").css("filter", "opacity(.75) grayscale(50%)");
  })
  .ajaxStop(function () {
    //got response so hide the loading image
    $('#loading').hide();
    $("#map").css("filter", "opacity(1) grayscale(0%)");
  });
