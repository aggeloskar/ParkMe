var center = [40.61914337227133, 22.96947253836266];
var mymap = L.map('mapid').setView(center, 13);
L.tileLayer(
   'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
         '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
         'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox.streets'
   }).addTo(mymap);

var popup = L.popup();

function onEachFeature(feature, layer) {
   var popupForm = 'GID: ' + feature.id + '<br>Population: ' + feature.properties.population + '<br>Demand: ' + feature.properties.demand + '%';

   layer.bindPopup(popupForm);
}

/*
//Color blocks based on demand (RED - YELLOW - GREEN)
function getColor(d) {
   return d > 85 ? '#d7191c' :
          d > 60 ? '#fee08b' :         
                   '#1a9850' ;
}
*/

//Color blocks based on demand (My colors)
function getColor(d) {
   return d > 100 ? '#d73027':
          d > 90 ? '#f46d43' :
          d > 85 ? '#fdae61' :
          d > 75 ? '#fee08b' :         
          d > 60 ? '#ffffbf' :
          d > 45 ? '#d9ef8b' :
          d > 35 ? '#a6d96a' :
          d > 0  ? '#66bd63' :
                   '#808080';
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

var geoJSONlayer = L.geoJSON(simpledata, {onEachFeature: onEachFeature, style: style}).addTo(mymap);

var parking;
if(mymap.hasLayer(parking)){
   mymap.removeLayer(parking);
}
parking = new L.GeoJSON.AJAX("mapdataonetime.js",{onEachFeature: onEachFeature, style: style});    
parking.addTo(mymap);


function draw(){
   if(mymap.hasLayer(parking)){
      mymap.removeLayer(parking);
   }
   parking = new L.GeoJSON.AJAX("mapdataonetime.js",{onEachFeature: onEachFeature, style: style});    
   parking.addTo(mymap);
}


function timeSelect(){
   var time = $("#timepicker").val();
   var hourmin = time.split(":");
   var hour = parseInt(hourmin[0],10);
   var min = parseInt(hourmin [1],10);
   if (min>30){
      hour++;
   }
   console.log("Timepicker time is " + hour);
   
}


