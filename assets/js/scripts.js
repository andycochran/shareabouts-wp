'use strict';

jQuery(document).foundation();

// smoothState
var options = {
    anchors: 'a.smoothstate',
    prefetch: true,
    cacheLength: 2,
    onStart: {
        duration: 500,
        render: function render($container) {
            $container.addClass('is-exiting');
            Foundation.Motion.animateOut(jQuery('#post'), 'fade-out');
            smoothState.restartCSSAnimations();
        }
    },
    onReady: {
        duration: 0,
        render: function render($container, $newContent) {
            $container.removeClass('is-exiting');
            $container.html($newContent);
            Foundation.Motion.animateIn(jQuery('#post'), 'fade-in');
            jQuery('#site-body').addClass('content-visible');
            map.invalidateSize();
        }
    }
},
    smoothState = jQuery('#content').smoothState(options).data('smoothState');

// If there's a map...
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
                    var place_url = feature.properties.permalink;
                    if (place_url != window.location) {
                        smoothState.load(place_url);
                    }
                });
            }
        }
    });

    jQuery(document).on("click", '#content-close-button', function (event) {
        jQuery('#site-body').removeClass('content-visible');
        map.invalidateSize();
        jQuery('#add-place').removeClass('hide');
    });

    jQuery(document).on("click", '#add-place', function (event) {
        event.preventDefault();
        var addPlaceURL = jQuery(this).attr('href');
        smoothState.load(addPlaceURL);
        Foundation.Motion.animateOut(jQuery(this), 'slide-out-down');
    });
} // ...end of if there's a map.