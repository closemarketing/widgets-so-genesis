<?php
/*
Widget Name: Featured products
Description: Shows featured products in widget.
Author: davidperez
Author URI: https://www.closemarketing.es
*/
function widget_woofeat() {
    register_widget( 'widget_woofeat' );
}
add_action( 'widgets_init', 'widget_woofeat' );

class widget_woofeat extends WP_Widget {

    // CONSTRUCT WIDGET
    function __construct() {
        $widget_ops = array(
            'classname'     => 'widget_woofeat',
            'description' => __('Shows featured products in widget','widgets-so-genesis'),
            'panels_icon' => 'dashicons dashicons-layout',
        );
        parent::__construct( 'widget_woofeat', __('Featured products','widgets-so-genesis'), $widget_ops );
    }

    // CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
      global $wpdb;

      // Check values
      if( $instance) {
           $title = esc_attr($instance['title']);
           $products_number = esc_attr($instance['products_number']);
      } else {
           $title = '';
           $products_number = '';
      }
      ?>

      <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" style="width:100%"/>
      </p>

      <p>
          <label for="<?php echo $this->get_field_id('products_number'); ?>"><?php _e('Number of products (-1 for all):', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('products_number'); ?>" name="<?php echo $this->get_field_name('products_number'); ?>" type="text" value="<?php echo $products_number; ?>"  style="width:100%"/>
      </p>
  <?php
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    // Fields
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['products_number'] = strip_tags($new_instance['products_number']);
    return $instance;

  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {

      extract( $args );

      // Widget starts to print information
      $before_widget = str_replace('class="', 'class="woocommerce ', $before_widget);
      echo $before_widget;

      if(isset($instance['title']) ) $title = apply_filters('widget_title', $instance['title']); else $title = '';
      if(isset($instance['products_number']) ) $products_number = $instance['products_number']; else $products_number = 3;
      ?>

      <h3 class="widget-title"><?php echo $title; ?></h3>
            <?php
            $args = array(
                  'post_type' => 'product',
                  'posts_per_page' => $products_number,
                  'tax_query' => array(
                       array(
                           'taxonomy' => 'product_visibility',
                           'field'    => 'name',
                           'terms'    => 'featured',
                           'operator' => 'IN'
                       ),
                  ),
            );
            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ) {
                  echo '<ul class="products">';
                  while ( $loop->have_posts() ) : $loop->the_post();
                        wc_get_template_part( 'content', 'product' );
                  endwhile;
                  echo '</ul>';
            } else {
                  echo __( 'No products found','widgets-so-genesis' );
            }
            wp_reset_postdata();
            ?>

      <?php
      // Widget ends printing information
      echo $after_widget;
  }

}