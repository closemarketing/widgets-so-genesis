<?php
/*
Widget Name: Images Category for WooCommerce
Description: Shows categories from WooCommerce.
Author: davidperez
Author URI: https://www.closemarketing.es
 */
function widget_woocatimg() {
	if (class_exists('WooCommerce')) //activates if woocommerce is present
	{
		register_widget('widget_woocatimg');
	}

}
add_action('widgets_init', 'widget_woocatimg');

class widget_woocatimg extends WP_Widget {

	// CONSTRUCT WIDGET
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_woocatimg',
			'description' => __('Images Category for WooCommerce', 'widgets-so-genesis'),
			'panels_icon' => 'dashicons dashicons-layout',
		);
		parent::__construct('widget_woocatimg', __('Shows parent categories from WooCommerce', 'widgets-so-genesis'), $widget_ops);
	}

	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
	function form($instance) {
		global $wpdb;

		// Check values
		if(isset($instance['title'])) $title = esc_attr($instance['title']); else $title = '';
		if(isset($instance['select'])) $select = esc_attr($instance['select']); else $select = '';
		if(isset($instance['select_imgsize'])) $select_imgsize = esc_attr($instance['select_imgsize']); else $select_imgsize = '';
		if(isset($instance['select_hide'])) $select_hide = esc_attr($instance['select_hide']); else $select_hide = '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'widgets-so-genesis');?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Genesis Columns', 'widgets-so-genesis');?></label>
			<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
			<?php
				$options = array(
					'half'   => __('2 Columns', 'widgets-so-genesis'),
					'third'  => __('3 Columns', 'widgets-so-genesis'),
					'fourth' => __('4 Columns', 'widgets-so-genesis'),
				);
				foreach ($options as $key => $option) {
					echo '<option value="' . $key . '" id="' . $key . '"', $select == $key ? ' selected="selected"' : '', '>'. $option. '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('select_imgsize'); ?>"><?php _e('Image', 'widgets-so-genesis');?></label>
			<select name="<?php echo $this->get_field_name('select_imgsize'); ?>" id="<?php echo $this->get_field_id('select_imgsize'); ?>" class="widefat">
			<?php
				$options_imgsize = get_intermediate_image_sizes();
				foreach ($options_imgsize as $optionim) {
					echo '<option value="' . $optionim . '" id="' . $optionim . '"', $select_imgsize == $optionim ? ' selected="selected"' : '', '>', $optionim, '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('select_hide'); ?>"><?php _e('Hide empty categories?', 'widgets-so-genesis');?></label>
			<select name="<?php echo $this->get_field_name('select_hide'); ?>" id="<?php echo $this->get_field_id('select_hide'); ?>" class="widefat">
				<?php
				$options_hide = array(
					true   => __('True', 'widgets-so-genesis'),
					false  => __('False', 'widgets-so-genesis')
				);
				foreach ($options_hide as $key => $option_hide) {
					echo '<option value="' . $key . '" id="' . $key . '"', $select_hide == $key ? ' selected="selected"' : '', '>', $option_hide, '</option>';
				}
				?>
			</select>
		</p>
	<?php
	}

	// UPDATE WIDGET
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['select'] = strip_tags($new_instance['select']);
		$instance['select_imgsize'] = strip_tags($new_instance['select_imgsize']);
		$instance['select_hide'] = strip_tags($new_instance['select_hide']);
		return $instance;

	}

	// DISPLAY WIDGET ON FRONT END
	function widget($args, $instance) {

		extract($args);

		// Widget starts to print information
		echo $before_widget;
		if(isset($instance['title'])) $title = esc_attr($instance['title']); else $title = '';
		if(isset($instance['select'])) $select = esc_attr($instance['select']); else $select = '';
		if(isset($instance['select_imgsize'])) $select_imgsize = esc_attr($instance['select_imgsize']); else $select_imgsize = '';
		if(isset($instance['select_hide'])) $select_hide = esc_attr($instance['select_hide']); else $select_hide = false;

		$args_terms     = array(
			'hide_empty' => $select_hide,
			'orderby'    => 'ASC',
			'parent'     => 0,
		);

		$catTerms = get_terms('product_cat', $args_terms);

		$i = 1;
		foreach ($catTerms as $catTerm):
			$wthumbnail_id = get_woocommerce_term_meta($catTerm->term_id, 'thumbnail_id', true);
			$wimage        = wp_get_attachment_image($wthumbnail_id, $select_imgsize);

			if ($title) { echo '<h2 class="widget-title">' . $title . '</h2>'; } ?>
	      	<div class="item <?php echo 'one-' . $select;if ($i == 1) { echo ' first'; $i++;} else { $i++;} ?>">
	            <a href="<?php echo esc_url(get_term_link($catTerm)); ?>">
	            	<?php if ($wimage != ""): ?><?php echo $wimage; ?><?php endif;?>
            	</a>
			<h3 class="title"><a href="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></a></h3>
        	</div>
        	<?php
		if ($select == 'half' && $i > 2) {	$i = 1;		
		} elseif ($select == 'third' && $i > 3) {	$i = 1;
		} elseif ($select == 'fourth' && $i > 4) { $i = 1;}

		endforeach;

		// Widget ends printing information
		echo $after_widget;
	}

}