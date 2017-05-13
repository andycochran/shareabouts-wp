'use strict';

// Post the login form
jQuery('#pt_login_form').on('submit', function(e){
  e.preventDefault();

  var button = jQuery(this).find('button');

  jQuery.post(ptajax.ajaxurl, jQuery('#pt_login_form').serialize(), function(data){
    var obj = jQuery.parseJSON(data);

    jQuery('.pt-login .pt-errors').html(obj.message);

    if(obj.error == false){
      window.location.reload(true);
    }

  });
});


// Post register form
jQuery('#pt_registration_form').on('submit', function(e){
  e.preventDefault();

  var button = jQuery(this).find('button');

  jQuery.post(ptajax.ajaxurl, jQuery('#pt_registration_form').serialize(), function(data){
    var obj = jQuery.parseJSON(data);

    jQuery('.pt-register .pt-errors').html(obj.message);

    if(obj.error == false){
      jQuery('#pt-user-modal .modal-dialog').addClass('registration-complete');
      // window.location.reload(true);
      button.hide();
    }

  });
});
