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

map.on('click', function(e) {        
    var clickedLocation= e.latlng;
    document.getElementById("clickedLocation").value = clickedLocation;

            
});

var time = new Date().toLocaleTimeString(); //get current time
document.getElementById("time").value = time;

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

var geoJSONlayer = L.geoJSON(mapdata11, {onEachFeature: onEachFeature, style: style}).addTo(map);
this.geoJSONlayer = L.geoJSON(destination, {onEachFeature: onEachFeature, style: style}).addTo(map);

function timeSelect(){
    var time = $("#timepicker").val();
    var hourmin = time.split(":");
    var hour = parseInt(hourmin[0],10);
    var min = parseInt(hourmin [1],10);
    if (min>30){
       hour++;
    }
    
 
    this.geoJSONlayer.clearLayers();
    //map.removeLayer(this.geoJSONlayer);
    //time = Math.floor((Math.random() * 10) + 13);
    time = hour;
    console.log(typeof(time));
    console.log(time);
 
    switch (time) {
       case 0:
          this.geoJSONlayer = L.geoJSON(mapdata0, {onEachFeature: onEachFeature, style: style}).addTo(map);
          break;
       case 1:
          this.geoJSONlayer = L.geoJSON(mapdata1, {onEachFeature: onEachFeature, style: style}).addTo(map);  
          break;
       case 2:
          this.geoJSONlayer = L.geoJSON(mapdata2, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 3:
          this.geoJSONlayer = L.geoJSON(mapdata3, {onEachFeature: onEachFeature, style: style}).addTo(map); 
          break;
       case 4:
          this.geoJSONlayer = L.geoJSON(mapdata4, {onEachFeature: onEachFeature, style: style}).addTo(map); 
          break;
       case 5:
          this.geoJSONlayer = L.geoJSON(mapdata5, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 6:
          this.geoJSONlayer = L.geoJSON(mapdata6, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 7:
          this.geoJSONlayer = L.geoJSON(mapdata7, {onEachFeature: onEachFeature, style: style}).addTo(map);
          break;
       case 8:
          this.geoJSONlayer = L.geoJSON(mapdata8, {onEachFeature: onEachFeature, style: style}).addTo(map);  
          break;
       case 9:
          this.geoJSONlayer = L.geoJSON(mapdata9, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 10:
          this.geoJSONlayer = L.geoJSON(mapdata10, {onEachFeature: onEachFeature, style: style}).addTo(map); 
          break;
       case 11:
          this.geoJSONlayer = L.geoJSON(mapdata11, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 12:
          this.geoJSONlayer = L.geoJSON(mapdata12, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 13:
       this.geoJSONlayer = L.geoJSON(mapdata13, {onEachFeature: onEachFeature, style: style}).addTo(map);
          break;
       case 14:
       this.geoJSONlayer = L.geoJSON(mapdata14, {onEachFeature: onEachFeature, style: style}).addTo(map);  
          break;
       case 15:
          this.geoJSONlayer = L.geoJSON(mapdata15, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 16:
       this.geoJSONlayer = L.geoJSON(mapdata16, {onEachFeature: onEachFeature, style: style}).addTo(map); 
          break;
       case 17:
          this.geoJSONlayer = L.geoJSON(mapdata17, {onEachFeature: onEachFeature, style: style}).addTo(map); 
          break;
       case 18:
          this.geoJSONlayer = L.geoJSON(mapdata18, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 19:
          this.geoJSONlayer = L.geoJSON(mapdata19, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 20:
          this.geoJSONlayer = L.geoJSON(mapdata20, {onEachFeature: onEachFeature, style: style}).addTo(map);
          break;
       case 21:
          this.geoJSONlayer = L.geoJSON(mapdata21, {onEachFeature: onEachFeature, style: style}).addTo(map);  
          break;
       case 22:
          this.geoJSONlayer = L.geoJSON(mapdata22, {onEachFeature: onEachFeature, style: style}).addTo(map);    
          break;
       case 23:
          this.geoJSONlayer = L.geoJSON(mapdata23, {onEachFeature: onEachFeature, style: style}).addTo(map);  
    }
 }