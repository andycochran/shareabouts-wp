jQuery(document).foundation();

// smoothState
var options = {
        anchors: 'a.ajax',
        prefetch: true,
        cacheLength: 2,
        onStart: {
            duration: 500,
            render: function ($container) {
                $container.addClass('is-exiting');
                Foundation.Motion.animateOut( jQuery('#post'), 'fade-out' );
                smoothState.restartCSSAnimations();
            }
        },
        onReady: {
            duration: 0,
            render: function ($container, $newContent) {
                $container.removeClass('is-exiting');
                $container.html($newContent);
                Foundation.Motion.animateIn( jQuery('#post'), 'fade-in' );
                jQuery('#site-body').addClass('content-visible');
                map.invalidateSize();
            }
        }
    },
    smoothState = jQuery('#content').smoothState(options).data('smoothState');

// If there's a map...
if ( jQuery( "#map" ).length ) {

    var map = L.map('map', {
        scrollWheelZoom: false
    }).setView([38.2431627,-85.7567134], 12);

    L.tileLayer('http://tile-c.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var popup = L.popup();

    jQuery.ajax({
        url: shareabouts.jsonurl,
        dataType: 'json',
        success: function (response) {

          var geojsonLayer = L.geoJson(response, {
              style: function(feature) {
                  return {
                    color: '#1779ba',
                    radius: 8,
                    fillOpacity: 0.5,
                  };
              },
              pointToLayer: function(feature, latlng) {
                  return new L.CircleMarker(latlng);
              },
              onEachFeature: onEachFeature
          });
          map.addLayer(geojsonLayer);

          function onEachFeature(feature, layer) {
              layer.on('click', function (e) {
                  var place_url = feature.properties.permalink;
                  if ( place_url != window.location ) {
                      smoothState.load(place_url);
                  }
              });
          }

        }
    });

    jQuery(document).on("click", '#content-close-button', function(event) {
        jQuery('#site-body').removeClass('content-visible');
        map.invalidateSize();
    });

} // ...end of if there's a map.
