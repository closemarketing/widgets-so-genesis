<?php
/*
Widget Name: Embedd Youtube video
Description: Use to embed a youtube video as a widget.
Author: davidperez
Author URI: https://www.closemarketing.es
*/
function widget_cmk_embed() {
    register_widget( 'widget_cmk_embed' );
}
add_action( 'widgets_init', 'widget_cmk_embed' );

class widget_cmk_embed extends WP_Widget {

    // CONSTRUCT WIDGET
    function __construct() {
        $widget_ops = array(
            'classname'     => 'widget_cmk_embed',
            'description' => __('Embed Video/Images from Youtube, Vimeo...','widgets-so-genesis'),
            'panels_icon' => 'dashicons dashicons-layout',
        );
        parent::__construct( 'widget_cmk_embed', __('Use to embed a video/images as a widget','widgets-so-genesis'), $widget_ops );
    }

    // CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
      global $wpdb;

      // Check values
      if( $instance) {
           $url_embed = esc_attr($instance['url_embed']);
           $height_embed = esc_attr($instance['height_embed']);
      } else {
           $url_embed = '';
           $height_embed = '';
      }
      ?>
      <p>
          <label for="<?php echo $this->get_field_id('url_embed'); ?>"><?php _e('Embed URL:', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('url_embed'); ?>" name="<?php echo $this->get_field_name('url_embed'); ?>" type="text" value="<?php echo $url_embed; ?>"  style="width:100%"/>
      </p>
      <p>
          <label for="<?php echo $this->get_field_id('height_embed'); ?>"><?php _e('Height:', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('height_embed'); ?>" name="<?php echo $this->get_field_name('height_embed'); ?>" type="text" value="<?php echo $height_embed; ?>"  style="width:60px"/> px
      </p>
  <?php
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    // Fields
    $instance['url_embed'] = strip_tags($new_instance['url_embed']);
    $instance['height_embed'] = strip_tags($new_instance['height_embed']);
    return $instance;

  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {

    extract( $args );
    $url_embed = $instance['url_embed'];
    $height_embed = $instance['height_embed'];

    if($url_embed) {
        // Widget starts to print information
        echo $before_widget;

        $html_embed = wp_oembed_get($url_embed);
        /* Modify video parameters. */
        if ( strstr( $html_embed,'youtube.com/embed/' ) ) {
          $height_pattern = "/height=\"[0-9]*\"/";
          $html_embed = preg_replace($height_pattern, 'height="'.$height_embed.'"', $html_embed);

          // Set the width of the video
          $width_pattern = "/width=\"[0-9]*\"/";
          $html_embed = preg_replace($width_pattern, "width='100%'", $html_embed);

          $html_embed = str_replace( 'feature=oembed', 'feature=oembed&wmode=transparent&rel=0&controls=0&showinfo=0', $html_embed );
        }
        echo $html_embed;

        // Widget ends printing information
        echo $after_widget;
    }
  }

}