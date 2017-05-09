// jQuery(document).on('submit', '#place-submission-form', function(e) {
jQuery('#place-submission-form').on('submit', function(e) {
    e.preventDefault();
    var title = jQuery('#place-submission-title').val();
    var content = jQuery('#place-submission-content').val();
    var location = jQuery('#place-submission-location').val();
    var status = 'publish';

    var data = {
        status: status,
        title: title,
        content: content,
        place_latlng: location
    };

    jQuery.ajax({
        method: 'POST',
        url: PLACE_SUBMITTER.root + 'wp/v2/shareabouts_place',
        data: data,
        beforeSend: function ( xhr ) {
            xhr.setRequestHeader( 'X-WP-Nonce', PLACE_SUBMITTER.nonce );
        },
        success : function( response ) {
            smoothState.load( response.link );
            var LatLng = JSON.parse('[' + response.place_latlng + ']');
            var marker = L.marker(LatLng).addTo(map);
            jQuery('#add-place').removeClass('hide');
            jQuery('#centerpoint').removeClass('newpin');
        },
        fail : function( response ) {
            console.log( response );
        }

    });

});
