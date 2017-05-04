'use strict';

jQuery(document).foundation();

// The Map
if (jQuery("#map").length) {

  var map = L.map('map', {
    scrollWheelZoom: false
  }).setView([38.2431627, -85.7567134], 12);

  L.tileLayer('http://tile-c.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  var popup = L.popup();

  jQuery.ajax({
    url: shareabouts.jsonurl,
    dataType: 'json',
    success: function success(response) {

      var geojsonLayer = L.geoJson(response, {
        style: function style(feature) {
          return {
            color: '#1779ba',
            radius: 8,
            fillOpacity: 0.5
          };
        },
        pointToLayer: function pointToLayer(feature, latlng) {
          return new L.CircleMarker(latlng);
        },
        onEachFeature: onEachFeature
      });
      map.addLayer(geojsonLayer);

      function onEachFeature(feature, layer) {
        layer.on('click', function (e) {
          window.open(feature.properties.permalink, '_self');
        });
      }
    }
  });

  jQuery('#content-close-button').click(function () {
    jQuery('#site-body').removeClass('content-visible');
    map.invalidateSize();
  });
}

// smoothState
jQuery(function () {
  'use strict';

  var options = {
    anchors: 'a',
    prefetch: true,
    cacheLength: 2,
    onStart: {
      duration: 500,
      render: function render($container) {
        $container.addClass('is-exiting');
        Foundation.Motion.animateOut(jQuery('#slider'), 'fade-out');
        smoothState.restartCSSAnimations();
      }
    },
    onReady: {
      duration: 0,
      render: function render($container, $newContent) {
        $container.removeClass('is-exiting');
        $container.html($newContent);
        Foundation.Motion.animateIn(jQuery('#slider'), 'hinge-in-from-middle-x');
      }
    }
  },
      smoothState = jQuery('#site-body').smoothState(options).data('smoothState');
});