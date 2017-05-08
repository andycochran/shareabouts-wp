jQuery( '#place-submission-form' ).on( 'submit', function(e) {
    e.preventDefault();
    var title = jQuery( '#place-submission-title' ).val();
    var excerpt = jQuery( '#place-submission-excerpt' ).val();
    var content = jQuery( '#place-submission-content' ).val();
    var status = 'draft';

    var data = {
        title: title,
        excerpt: excerpt,
        content: content
    };

    jQuery.ajax({
        method: "POST",
        url: PLACE_SUBMITTER.root + 'wp/v2/shareabouts_place',
        data: data,
        beforeSend: function ( xhr ) {
            xhr.setRequestHeader( 'X-WP-Nonce', PLACE_SUBMITTER.nonce );
        },
        success : function( response ) {
            console.log( response );
            alert( PLACE_SUBMITTER.success );
        },
        fail : function( response ) {
            console.log( response );
            alert( PLACE_SUBMITTER.failure );
        }

    });

});
