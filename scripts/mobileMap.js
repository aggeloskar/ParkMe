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

L.geoJSON(mapdata, {
    onEachFeature: onEachFeature,
    style: style
}).addTo(map);