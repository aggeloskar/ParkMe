var center = [40.61914337227133, 22.96947253836266];
var map = L.map('map').setView(center, 13);

L.tileLayer(
   'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
         '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
         'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox.streets'
   }).addTo(map);

function onLocationFound(e) {
   var radius = e.accuracy / 2;

   L.marker(e.latlng).addTo(map)
      .bindPopup("You are within " + radius + " meters from this point").openPopup();

   L.circle(e.latlng, radius).addTo(map);
}

function onLocationError(e) {
   console.log("Location Error");
}

var newMarker;
var radiusInput = 150;

$( "#radius" )
  .keyup(function() {
    radiusInput = $( this ).val();
    
  })


map.on('click', function (e) {
   var clickedLocation = e.latlng;
   document.getElementById("clickedLocation").value = clickedLocation;
   if (typeof (newMarker) === 'undefined') {
      newMarker = new L.marker(e.latlng, {
         draggable: false,
         //icon: greenMarker
      });
      newMarker.addTo(map);
      newRadius = new L.circle(e.latlng, {
         radius: radiusInput
      });
      newRadius.addTo(map);
   } else {
      map.removeLayer(newMarker);
      newMarker = new L.marker(e.latlng, {
         draggable: false,
         radius: radiusInput
         //icon: greenMarker
      });
      newMarker.addTo(map);
      map.removeLayer(newRadius);
      newRadius = new L.circle(e.latlng, {
         radius: radiusInput
      });
      newRadius.addTo(map);
   }
});


var time = new Date().toLocaleTimeString(); //get current time

map.on('locationfound', onLocationFound);
map.on('locationerror', onLocationError);

map.locate({
   setView: true,
   maxZoom: 16
});


function onEachFeature(feature, layer) {
   var popupForm = 'GID: ' + feature.id + '<br>Population: ' + feature.properties.population + '<br>Demand: ' + feature.properties.demand + '%';

   layer.bindPopup(popupForm);
}

//Color blocks based on demand
function getColor(d) {
   return d > 85 ? '#d73027' :
      d > 60 ? '#f46d43' :
      '#a6d96a';
}

function style(feature) {
   return {
      fillColor: getColor(feature.properties.demand),
      fillOpacity: 0.7,
      weight: 0
   };
}

var emptyStyle = {
   "color": "#808080",
   "weight": 1,
   "fillOpacity": 0.55
};
var date = new Date();
var time = date.getHours();

//var geoJSONlayer = L.geoJSON(mapdata11, {onEachFeature: onEachFeature, style: style}).addTo(map);
//this.geoJSONlayer = L.geoJSON(destination, {onEachFeature: onEachFeature, style: style}).addTo(map);
var geoJsonlayer = new L.GeoJSON.AJAX("mapdataonetime.js", {
   onEachFeature: onEachFeature,
   style: style
});
geoJsonlayer.addTo(map);

var parking;

function draw() {
   if (map.hasLayer(parking)) {
      map.removeLayer(parking);
   }
   parking = new L.GeoJSON.AJAX("destination.js");
   parking.addTo(map);
}

function drawMap() {
   map.removeLayer(geoJsonlayer);
   geoJsonlayer = new L.GeoJSON.AJAX("mapdataonetime.js", {
      onEachFeature: onEachFeature,
      style: style
   });
   geoJsonlayer.addTo(map);
}

function timeSelect() {
   var time = $("#timepicker").val();
   var hourmin = time.split(":");
   var hour = parseInt(hourmin[0], 10);
   var min = parseInt(hourmin[1], 10);
   if (min > 30) {
      hour++;
   }

   time = hour;
   var values = "time=" + time;

   $.ajax({
      type: "POST",
      url: "runSingleSimulation.php",
      data: values,
      // if sent
      success: function () {
         drawMap();
      },
      error: function () {
         alert("Something went wrong");
      }
   });
   event.preventDefault();


}

var greenMarker = L.icon({
   iconUrl: 'images/locationmarker2.png',
   iconSize:     [38, 38], // size of the icon
   iconAnchor:   [20, 25], // point of the icon which will correspond to marker's location
});