<?php

// USER MODAL
function pt_login_register_modal() {
  // only show the registration/login form to non-logged-in members
  if ( ! is_user_logged_in() ) { ?>
    <div class="reveal" id="pt-user-modal" data-reveal>

      <?php if( get_option('users_can_register') ){ ?>

      <!-- Login form -->
      <div id="pt-login" class="pt-login" data-toggler=".hide">
        <h4 class="text-inline-block"><?php _e('Sign in', 'shareabouts'); ?>&nbsp;</h4>
        <small><a href="#" data-toggle="pt-register pt-login"><strong><?php _e('Need an account?', 'shareabouts'); ?></strong></a></small>
        <form id="pt_login_form" action="<?php echo home_url( '/' ); ?>" method="post">
          <label><?php _e('Username', 'shareabouts') ?></label>
          <input type="text" name="pt_user_login" id="pt_user_login" class="" required>

          <label for="pt_user_pass"><?php _e('Password', 'shareabouts')?></label>
          <input type="password" name="pt_user_pass" id="pt_user_pass" class="" required>

          <input type="hidden" name="action" value="pt_login_member">

          <button class="button" data-loading-text="<?php _e('Loading...', 'shareabouts') ?>" type="submit"><?php _e('Sign in', 'shareabouts'); ?></button>
          <a class="button--clear float-right" href="#pt-reset-password"><?php _e('Lost Password?', 'shareabouts') ?></a>

          <?php wp_nonce_field( 'ajax-login-nonce', 'login-security' ); ?>
        </form>
        <div class="pt-errors"></div>
      </div>

      <!-- Register form -->
      <div id="pt-register" class="pt-register hide" data-toggler=".hide">
        <h4 class="text-inline-block"><?php _e('Create an account', 'shareabouts'); ?>&nbsp;</h4>
        <small><a href="#" data-toggle="pt-register pt-login"><strong><?php _e('Sign in', 'shareabouts'); ?></strong></a></small>
        <form id="pt_registration_form" action="<?php echo home_url( '/' ); ?>" method="POST">
          <label for="pt_user_login"><?php _e('Username', 'shareabouts'); ?></label>
          <input type="text" name="pt_user_login" id="pt_user_login" class="" required>

          <label for="pt_user_email"><?php _e('Email', 'shareabouts'); ?></label>
          <input type="email" name="pt_user_email" id="pt_user_email" class="" required>

          <input type="hidden" name="action" value="pt_register_member">

          <button class="button" data-loading-text="<?php _e('Loading...', 'shareabouts') ?>" type="submit"><?php _e('Create account', 'shareabouts'); ?></button>

          <?php wp_nonce_field( 'ajax-login-nonce', 'register-security' ); ?>
        </form>
        <div class="pt-errors"></div>
      </div>

      <?php } else {
        echo '<h3>'.__('Login access is disabled', 'shareabouts').'</h3>';
      } ?>
      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php
  }
}
add_action('wp_footer', 'pt_login_register_modal');


// LOGIN FUNCTION
function pt_login_member() {
  $user_login    = $_POST['pt_user_login'];
  $user_pass    = $_POST['pt_user_pass'];

  // Check CSRF token
  if ( !check_ajax_referer( 'ajax-login-nonce', 'login-security', false) ) {
    echo json_encode(array('error' => true, 'message'=> '<div class="callout alert">'.__('Session token has expired, please reload the page and try again', 'shareabouts').'</div>'));
  } elseif ( empty($user_login) || empty($user_pass) ) {
    // Input variables are empty
    echo json_encode(array('error' => true, 'message'=> '<div class="callout alert">'.__('Please fill all form fields', 'shareabouts').'</div>'));
  } else {
    // Add user account
    $user = wp_signon( array('user_login' => $user_login, 'user_password' => $user_pass), false );
    if ( is_wp_error($user) ) {
      echo json_encode(array('error' => true, 'message'=> '<div class="callout alert">'.$user->get_error_message().'</div>'));
    } else {
      echo json_encode(array('error' => false, 'message'=> '<div class="callout success">'.__('Login successful, reloading page...', 'shareabouts').'</div>'));
    }
  }
  die();
}
add_action('wp_ajax_nopriv_pt_login_member', 'pt_login_member');


// REGISTER FUNCTION
function pt_register_member(){
  $user_login  = $_POST['pt_user_login'];
  $user_email  = $_POST['pt_user_email'];

  // Check CSRF token
  if ( !check_ajax_referer( 'ajax-login-nonce', 'register-security', false) ) {
    echo json_encode(array('error' => true, 'message'=> '<div class="callout alert">'.__('Session token has expired, please reload the page and try again', 'shareabouts').'</div>'));
    die();
  } elseif ( empty($user_login) || empty($user_email) ) {
    // Input variables are empty
    echo json_encode(array('error' => true, 'message'=> '<div class="callout alert">'.__('Please fill all form fields', 'shareabouts').'</div>'));
    die();
  }

  $errors = register_new_user($user_login, $user_email);

  if ( is_wp_error($errors) ) {
    $registration_error_messages = $errors->errors;
    $display_errors = '<div class="callout alert">';

    foreach($registration_error_messages as $error){
      $display_errors .= '<p>'.$error[0].'</p>';
    }
    $display_errors .= '</div>';
      echo json_encode(array('error' => true, 'message' => $display_errors));
    } else {
      echo json_encode(array('error' => false, 'message' => '<div class="callout success">'.__( 'Registration complete. Please check your e-mail.', 'shareabouts').'</p>'));
    }

    die();
}
add_action('wp_ajax_nopriv_pt_register_member', 'pt_register_member');
