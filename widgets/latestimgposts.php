<?php
/*
Widget Name: Latest Posts with image
Description: Shows the latest posts with thumbnail.
Author: davidperez, afortunato
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
            'description' => 'Últimas entradas personalizable',
            'panels_icon' => 'dashicons dashicons-layout',
        );
        parent::__construct( 'widget_latestimgposts', __('Shows the latest posts with thumbnail','widgets-so-genesis'), $widget_ops );
    }

    // CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
      global $wpdb;


       // Check values
      if( $instance) {
           $wtitle = esc_attr($instance['wtitle']);
           $entries_amount = esc_attr($instance['entries_amount']);
           $select_order = esc_attr($instance['select_order']);
           $select_orderby = esc_attr($instance['select_orderby']);
           $select_cols = esc_attr($instance['select_cols']);
           $show_date = esc_attr($instance['show_date']);
           $select_imgsize = esc_attr($instance['select_imgsize']);
      } else {
           $wtitle = '';
           $select_imgsize = '';
           $entries_amount = '';
           $select_order = '';
           $select_orderby = '';
           $select_cols = '';
           $show_date = '';
      }
      ?>

      <p>
          <label for="<?php echo $this->get_field_id('wtitle'); ?>"><?php _e('Widget Title', 'widgets-so-genesis'); ?></label>
          <input id="<?php echo $this->get_field_id('wtitle'); ?>" name="<?php echo $this->get_field_name('wtitle'); ?>" type="text" value="<?php echo $wtitle; ?>" style="width:100%;" />
      </p>

      <p>
          <label for="<?php echo $this->get_field_id('entries_amount'); ?>"><?php _e('Amount of entries to show', 'widgets-so-genesis'); ?></label>
          <select id="<?php echo $this->get_field_id('entries_amount'); ?>"  name="<?php echo $this->get_field_name('entries_amount'); ?>">
            <?php for($x=1;$x<=10;$x++): ?>
            <option <?php echo $x == $entries_amount ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
            <?php endfor;?>
          </select>
      </p>

      <p>
          <label for="<?php echo $this->get_field_id('select_cols'); ?>"><?php _e('Genesis Columns', 'widgets-so-genesis'); ?></label>
          <select name="<?php echo $this->get_field_name('select_cols'); ?>" id="<?php echo $this->get_field_id('select_cols'); ?>" class="widefat">
          <?php
          $options = array(
                        'whole' => __('1 Column', 'widgets_so_genesis'),
                        'half' => __('2 Columns', 'widgets-so-genesis'), 
                        'third' => __('3 Columns', 'widgets-so-genesis'), 
                        'fourth' => __('4 Columns', 'widgets-so-genesis')
            );
          foreach ($options as $key => $option) {
          echo '<option value="' . $key . '" id="' . $key . '"', $select_cols == $key ? ' selected="selected"' : '', '>', $option, '</option>';
          }
          ?>
          </select>
      </p>

      <p>
          <label for="<?php echo $this->get_field_id('select_orderby'); ?>"><?php _e('Order By', 'widgets-so-genesis'); ?></label>
          <select name="<?php echo $this->get_field_name('select_orderby'); ?>" id="<?php echo $this->get_field_id('select_orderby'); ?>" class="widefat">
          <?php
          $options = array(
                        'date' => __('By Date', 'widgets-so-genesis'), 
                        'ID' => __('By ID', 'widgets-so-genesis'),
                        'author' => __('By author', 'widgets-so-genesis'), 
                        'title' => __('By title', 'widgets-so-genesis'),
                        'name' => __('By name', 'widgets-so-genesis'), 
                        'type' => __('By type', 'widgets-so-genesis'),
                        'modified' => __('By modified', 'widgets-so-genesis'), 
                        'parent' => __('By parent', 'widgets-so-genesis'),
                        'comment_count' => __('By number of comments', 'widgets-so-genesis'),
                        'relevance' => __('By relevance', 'widgets-so-genesis'), 
                        'random' => __('Randomly', 'widgets-so-genesis'), 
                        'none' => __('No order', 'widgets-so-genesis')
            );
          foreach ($options as $key => $option) {
            echo '<option value="' . $key . '" id="' . $key . '"', $select_orderby == $key ? ' selected="selected"' : '', '>', $option, '</option>';
          }
          ?>
          </select>
      </p>

      <p>
          <label for="<?php echo $this->get_field_id('select_order'); ?>"><?php _e('Order', 'widgets-so-genesis'); ?></label>
          <select name="<?php echo $this->get_field_name('select_order'); ?>" id="<?php echo $this->get_field_id('select_order'); ?>" class="widefat">
          <?php
          $options = array(
                        'DESC' => __('Descending order', 'widgets-so-genesis'),
                        'ASC' => __('Ascending order', 'widgets_so_genesis')          
            );
          foreach ($options as $key => $option_order) {
            echo '<option value="' . $key . '" id="' . $key . '"', $select_order == $key ? ' selected="selected"' : '', '>', $option_order, '</option>';
          }
          ?>
          </select>
      </p>

      <p>
        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'show_date' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" /> 
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e('Show date?', 'widgets-so-genesis'); ?></label>
      </p>

      <p>
      <label for="<?php echo $this->get_field_id('select_imgsize'); ?>"><?php _e('Image', 'widgets-so-genesis'); ?></label>
          <select name="<?php echo $this->get_field_name('select_imgsize'); ?>" id="<?php echo $this->get_field_id('select_imgsize'); ?>" class="widefat">
          <?php
          $options_imgsize = get_intermediate_image_sizes();
          echo '<option value="no-image"' . 'id="no-image"', $select_imgsize == 'no-image' ? ' selected="selected"' : '', '>', "No image", '</option>';
          foreach ($options_imgsize as $optionim) {
            echo '<option value="' . $optionim . '" id="' . $optionim . '"', $select_imgsize == $optionim ? ' selected="selected"' : '', '>', $optionim, '</option>';
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
    $instance['wtitle'] = strip_tags($new_instance['wtitle']);
    $instance['entries_amount'] = $new_instance['entries_amount'];
    $instance['select_order'] = $new_instance['select_order'];
    $instance['select_orderby'] = $new_instance['select_orderby'];
    $instance['select_cols'] = strip_tags($new_instance['select_cols']);
    $instance['show_date'] = $new_instance[ 'show_date' ];
    $instance['select_imgsize'] = $new_instance['select_imgsize'];

    return $instance;

  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {

      extract( $args );

        // Widget starts to print information
        echo $before_widget;
        $wtitle = apply_filters('widget_title', $instance['wtitle']);
        $entries_amount = $instance['entries_amount'];
        $select_order = $instance['select_order'];
        $select_orderby = $instance['select_orderby'];
        $select_cols = $instance['select_cols'];
        $show_date = $instance[ 'show_date' ] ? 'true' : 'false';
        $select_imgsize = $instance['select_imgsize'];
        $args_terms = array(
          'hide_empty' => 0,
          'parent' => 0,
          );

        $entryTerms = get_terms('entry_post', $args_terms);



        if(isset($instance['title']) ) $title = apply_filters('widget_title', $instance['title']); else $title = '';
        ?>

        <?php
        $args_query = array(
            'post_type' => 'post',
            'posts_per_page' => $entries_amount,
            'orderby' => $select_orderby, 
            'order' => $select_order,
        );
        
        // The Query
        $the_query = new WP_Query( $args_query );
        
        // The Loop
        if ( $the_query->have_posts() ) {
            $j = 1;
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $post_thumbnail_id = get_post_thumbnail_id( get_the_ID());
                $post_image = wp_get_attachment_image( $post_thumbnail_id, $select_imgsize );

        ?>
        
                <div class="item <?php echo 'one-'.$select_cols; if($j==1) { echo ' first'; $j++; } else { $j++; }?>">
                  <?php if($post_image!="" && $select_imgsize!="no-image"):?>
                   <div class="entry-img">
                      <a href="<?php the_permalink() ?>"><?php echo $post_image; ?></a>
                   </div>
                 <?php endif; ?>
                 <div class="title">
                     <h2 class="widget-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h3><?php the_excerpt(); ?>
                 </div>

                  <?php if( 'on' == $instance[ 'show_date' ] ) : ?>
                  <div class="time">
                    <time class="date-info" datetime="<?php the_time(__('F jS, Y','widgets-so-genesis')); ?>" pubdate>
                    <?php the_time( get_option('date_format') ); ?>
                    </time>
                  </div>
                  <?php endif; ?>
              
                </div>
            <?php 
            if($select_cols=='half'&&$j>2) $j = 1;
            elseif($select_cols=='third'&&$j>3) $j = 1;
            elseif($select_cols=='fourth'&&$j>4) $j = 1;
            elseif($select_cols=='whole'&&$j>1) $j = 1;

            }
            /* Restore original Post Data */
            wp_reset_postdata();
        } 
        // Widget ends printing information
        echo $after_widget;
  }

} //from class