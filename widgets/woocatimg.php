<?php
/*
Widget Name: Images Category for Woocommerce
Description: Shows categories from Woocommerce.
Author: davidperez
Author URI: https://www.closemarketing.es
*/
function widget_woocatimg() {
    register_widget( 'widget_woocatimg' );
}
add_action( 'widgets_init', 'widget_woocatimg' );

class widget_woocatimg extends WP_Widget {

    // CONSTRUCT WIDGET
    function __construct() {
        $widget_ops = array(
            'classname'     => 'widget_woocatimg',
            'description' => 'Images Category for Woocommerce',
            'panels_icon' => 'dashicons dashicons-layout',
        );
        if ( class_exists( 'WooCommerce' ) )  //activates if woocommerce is present
            parent::__construct( 'widget_woocatimg', __('Shows parent categories from Woocommerce','widgets-so-genesis'), $widget_ops );
    }

    // CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
      global $wpdb;

      // Check values
      if( $instance) {
           $title = esc_attr($instance['title']);
           $select = esc_attr($instance['select']); // Added
      } else {
           $title = '';
           $select = ''; // Added
      }
      ?>

      <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" style="width:100%;" />
      </p>

      <p>
      <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Genesis Columns', 'widgets-so-genesis'); ?></label>
          <select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
          <?php
          $options = array(
                        'half' => __('2 Columns', 'widgets-so-genesis'), 
                        'third' => __('3 Columns', 'widgets-so-genesis'), 
                        'fourth' => __('4 Columns', 'widgets-so-genesis')
            );
          foreach ($options as $key => $option) {
          echo '<option value="' . $key . '" id="' . $key . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
          }
          ?>
          </select>
      </p>
  <?php
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    // Fields
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['select'] = strip_tags($new_instance['select']);
    return $instance;

  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {

      extract( $args );

        // Widget starts to print information
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        $select = $instance['select'];
        $catTerms = get_terms('product_cat', array('hide_empty' => 0, 'orderby' => 'ASC' ));

        $i = 1;
        foreach($catTerms as $catTerm) : 
               $wthumbnail_id = get_woocommerce_term_meta( $catTerm->term_id,'thumbnail_id', true );
               $wimage = wp_get_attachment_url( $wthumbnail_id );
        
        if($title) echo '<h2 class="widget-title">'.$title.'</h2>';
        ?>

        <div class="item <?php echo 'one-'.$select; if($i==1) { echo ' first'; $i++; } else { $i++; }?>">
            <a href="<?php echo $catTerm->slug; ?>">
                <?php if($wimage!=""):?><img src="<?php echo $wimage?>" /><?php endif;?>
            </a>
            <h3 class="title">
                <a href="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></a>
            </h3>
        </div>
        <?php
        if($select=='half'&&$i>2) $i = 1;
        elseif($select=='third'&&$i>3) $i = 1;
        elseif($select=='fourth'&&$i>4) $i = 1;

        endforeach; 

        // Widget ends printing information
        echo $after_widget;
  }

}