var $loading = $('#loading').hide();

$(document)
  .ajaxStart(function () {
    //ajax request went so show the loading image
    $loading.show();
    $('#mapid').hide();
  })
  .ajaxStop(function () {
    //got response so hide the loading image
    $loading.hide();
    //$('#mapid').show();
  });