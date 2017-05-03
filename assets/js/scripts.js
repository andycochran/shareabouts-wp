'use strict';

jQuery(document).foundation();

var map = L.map('map', {
  scrollWheelZoom: false
}).setView([38.2431627, -85.7567134], 12);

L.tileLayer('http://tile-c.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var popup = L.popup();

function onMapClick(e) {
  popup.setLatLng(e.latlng).setContent("You clicked the map at " + e.latlng.toString()).openOn(map);
}

map.on('click', onMapClick);

jQuery.ajax({
  url: 'http://localhost/~andy/wp-shareabouts/wp-json/shareabouts/v1/places.json',
  dataType: 'json',
  success: function success(response) {
    var geojsonLayer = L.geoJson(response).addTo(map);
  }
});

jQuery('#content-close-button').click(function () {
  jQuery('#site-body').removeClass('content-visible');
  map.invalidateSize();
});