<?php
/*
Widget Name: Button iOS App
Description: Download button for ios apps.
Author: davidperez
Author URI: https://www.closemarketing.es
*/
function widget_bios() {
    register_widget( 'widget_bios' );
}
add_action( 'widgets_init', 'widget_bios' );

class widget_bios extends WP_Widget {

    // CONSTRUCT WIDGET
    function __construct() {
        $widget_ops = array(
            'classname'     => 'widget_bios',
            'description' => __('Button iOS App','widgets-so-genesis'),
            'panels_icon' => 'dashicons dashicons-layout',
        );
        parent::__construct( 'widget_bios', __('Download button for ios apps','widgets-so-genesis'), $widget_ops );
    }

    // CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
      global $wpdb;

      // Check values
      if( $instance) {
           $url = esc_attr($instance['url']);
      } else {
           $url = '';
      }
      ?>
      <p>
          <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL Appstore Download App', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" style="width:100%"/>
      </p>

  <?php
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    // Fields
    $instance['url'] = strip_tags($new_instance['url']);
    return $instance;

  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {

      extract( $args );

        // Widget starts to print information
        echo $before_widget;
        $url = $instance['url'];
        $locale = substr(get_locale(), 0, 2);
        ?>

        <div class="btn-app-store-element"><a class="btn-app-store" href="<?php echo $url;?>" target="_blank"><img src="<?php echo plugin_dir_url( __FILE__ );?>images/appstore-<?php echo $locale;?>.png"/></a></div>

        <?php
        // Widget ends printing information
        echo $after_widget;

  }

}