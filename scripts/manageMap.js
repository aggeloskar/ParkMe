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
   var popupForm = 'GID: ' + feature.id + '<br>Population: ' + feature.properties.population + '<form id="addBlock" action="addBlock.php" method="post">Parking spots:<br><input type="text" name="spots" size="5" pattern="([1-9][0-9]{0,2}|1000)" title="Number 1-1000"/><br>Curve:<br><select name = "curve"><option value="1">Center</option><option value="2">Residential</option><option value="3">Stable</option></select><input type="hidden" name="gid" value="' + feature.id + '"><br><input type="submit" value="Submit"/></form><div id="blockAdded"></div>';

   layer.bindPopup(popupForm);
}

/*
//Color blocks based on demand
function getColor(d) {
   return d > 85 ? '#d73027' :
          d > 60  ? '#f46d43' :         
                   '#a6d96a';
}

function style(feature) {
   return {
       fillColor: getColor(feature.properties.demand),
       fillOpacity: 0.7,
       weight: 0
   };
}
*/

var emptyStyle = {
   "color": "#808080",
   "weight": 1,
   "fillOpacity": 0.55
};

var graymap = L.geoJSON(simpledata, {onEachFeature: onEachFeature, style: emptyStyle}).addTo(mymap);

function resetmap(){
   mymap.removeLayer(graymap);
   mymap.removeLayer(geoJSONlayer);
   document.location.reload(true);
}




