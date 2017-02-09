<?php
/*
Widget Name: Latest Posts with image
Description: Shows the latest posts with thumbnail.
Author: davidperez
Author URI: https://www.closemarketing.es
*/
function widget_latestimgposts() {
    register_widget( 'widget_latestimgposts' );
}
add_action( 'widgets_init', 'widget_latestimgposts' );

class widget_latestimgposts extends WP_Widget {

    // CONSTRUCT WIDGET
    function __construct() {
        $widget_ops = array(
            'classname'     => 'widget_latestimgposts',
            'description' => __('Latest Posts with image','widgets-so-genesis'),
            'panels_icon' => 'dashicons dashicons-layout',
        );
        parent::__construct( 'widget_latestimgposts', __('Shows the latest posts with thumbnail','widgets-so-genesis'), $widget_ops );
    }

    // CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
      global $wpdb;

      // Check values
      if( $instance) {
           $title = esc_attr($instance['title']);
      } else {
           $title = '';
      }
      ?>

      <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" style="width:100%" />
      </p>

  <?php
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    // Fields
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;

  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {

      extract( $args );

        // Widget starts to print information
        echo $before_widget;
        if(isset($instance['title'])) $title = apply_filters('widget_title', $instance['title']); else $title='';
        ?>

        <?php 
        if($title) 
            echo '<h2 class="widget-title">'.esc_html($instance['title']).'</h2>';

        $args_posts = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
        );

        $latestposts = new WP_Query( $args_posts );

        if ( $latestposts->have_posts() ) :
        $i =1;
        while ( $latestposts->have_posts() ) : $latestposts->the_post();    ?>
            <div class="one-third item <?php if($i==1) { echo ' first'; $i++; } else { $i++; } ?>">
               <div class="thumbnails">
                   <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                   <?php the_post_thumbnail( 'thumbnail' ); ?>
                    </a>
               </div>
               <div class="title">
                   <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h3><?php the_excerpt(); ?>
               </div>
            </div>
        <?php
        if($i>3) $i = 1;
        endwhile;
        wp_reset_postdata();
        endif;
        ?>

        <?php
        // Widget ends printing information
        echo $after_widget;

  }

}