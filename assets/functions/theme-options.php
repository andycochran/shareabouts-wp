<?php
function shareabouts_theme_options() {
  add_submenu_page( 'edit.php?post_type=shareabouts_place', 'Shareabouts Options', 'Shareabouts Options', 'manage_options', 'shareabouts-options', 'shareabouts_options' );
  add_action( 'admin_init', 'register_shareabouts_options' );
}
add_action( 'admin_menu', 'shareabouts_theme_options' );

function register_shareabouts_options() {
  register_setting( 'shareabouts-options-group', 'add_place_button', 'sanitize_shareabouts_options' );
  register_setting( 'shareabouts-options-group', 'submit_place_button', 'sanitize_shareabouts_options' );
}

function sanitize_shareabouts_options ($input) {
  global $allowedposttags;
  $input = wp_kses( $input, $allowedposttags);
  return $input;
}

function shareabouts_options() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  ?>
  <div class="wrap">
    <div id="icon-edit" class="icon32"></div>
    <h1><?php _e('Shareabouts Options', 'shareabouts') ?></h1>
    <form method="post" action="options.php">
      <?php settings_fields( 'shareabouts-options-group' ); ?>
      <?php do_settings_sections( 'shareabouts-options-group' ); ?>
      <table class="form-table">

        <tr valign="top">
          <th scope="row">Add Place Button</th>
          <td>
            <input type="text" name="add_place_button" value="<?php echo esc_attr( get_option('add_place_button') ); ?>" size="30" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Submit Place Button</th>
          <td>
            <input type="text" name="submit_place_button" value="<?php echo esc_attr( get_option('submit_place_button') ); ?>" size="30" />
          </td>
        </tr>

      </table>

      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}
