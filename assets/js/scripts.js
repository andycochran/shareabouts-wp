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
    var addingPlace = function addingPlace(adding) {
        if (adding == true) {
            jQuery('#add-place').addClass('hide');
            jQuery('#centerpoint').addClass('newpin');
        } else {
            jQuery('#add-place').removeClass('hide');
            jQuery('#centerpoint').removeClass('newpin');
        }
    };

    var map = L.map('map', {
        scrollWheelZoom: false
    }).setView(shareabouts.mapDefaultCenter, shareabouts.mapDefaultZoom);

    L.tileLayer('http://tile-c.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        minZoom: 4,
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var popup = L.popup();
    var selected;
    var markerStyle = {
        color: '#1779ba',
        weight: 4,
        radius: 8,
        fillColor: '#1779ba',
        fillOpacity: 0.5
    };
    var selectedMarkerStyle = {
        color: '#dd0000',
        weight: 5,
        radius: 10,
        fillColor: '#eeeeee',
        fillOpacity: 1
    };

    jQuery.ajax({
        url: shareabouts.jsonurl,
        dataType: 'json',
        success: function success(response) {

            var geojsonLayer = L.geoJson(response, {
                style: function style() {
                    return markerStyle;
                },
                pointToLayer: function pointToLayer(feature, latlng) {
                    return new L.CircleMarker(latlng);
                },
                onEachFeature: onEachFeature
            });
            map.addLayer(geojsonLayer);

            function onEachFeature(feature, layer) {
                var place_url = feature.properties.permalink;
                layer.on('click', function (e) {
                    smoothState.load(place_url);

                    if (selected) {
                        geojsonLayer.resetStyle(selected);
                    }
                    selected = e.target;
                    selected.bringToFront();
                    selected.setStyle(selectedMarkerStyle);

                    addingPlace(false);
                });
                if (place_url == window.location) {
                    layer.setStyle(selectedMarkerStyle);
                    selected = layer;
                }
            }
        }
    });

    jQuery(document).on('click', '#content-close-button', function (event) {
        // TODO: Add baseURL to history when content panel is closed
        // window.history.pushState({'href':shareabouts.homeurl},'', shareabouts.homeurl);
        if (selected) {
            selected.setStyle(markerStyle);
        }
        jQuery('#site-body').removeClass('content-visible');
        map.invalidateSize();
        addingPlace(false);
    });

    jQuery(document).on("click", '#add-place', function (event) {
        event.preventDefault();
        if (selected) {
            selected.setStyle(markerStyle);
        }
        var addPlaceURL = jQuery(this).attr('href');
        smoothState.load(addPlaceURL);
        addingPlace(true);
        Foundation.Motion.animateIn(jQuery('#centerpoint'), 'fade-in');
    });

    map.on('movestart', function (e) {
        jQuery('#centerpoint').addClass('dragging');
    });
    map.on('moveend', function (e) {
        jQuery('#centerpoint').removeClass('dragging');
        var mapCenter = map.getCenter();
        mapCenter = mapCenter.lat + ", " + mapCenter.lng;
        jQuery('#place-submission-location').val(mapCenter);
    });
} // ...end of if there's a map.