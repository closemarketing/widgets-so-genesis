<?php
/**
 * Closemarketing
 *
 * @package WordPress
 * @subpackage Closemarketing
 * @author Closemarketing <info@closemarketing.es>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

class BSC_Button extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_cta', 'description' => __('Add a Button Bootstrap', 'bsc'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('ctatext', __('Button to Action','bsc'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$buttontext = apply_filters( 'widget_buttontext', empty( $instance['buttontext'] ) ? '' : $instance['buttontext'], $instance );
		$buttonsize = apply_filters( 'widget_buttonsize', empty( $instance['buttonsize'] ) ? '' : $instance['buttonsize'], $instance );
		$buttonstyle = apply_filters( 'widget_buttonstyle', empty( $instance['buttonstyle'] ) ? '' : $instance['buttonstyle'], $instance );
		$buttonurl = apply_filters( 'widget_buttonurl', empty( $instance['buttonurl'] ) ? '' : $instance['buttonurl'], $instance );
		echo $before_widget; ?>

			<div class="ctabutton">
                <a class="btn<?php
                    if ( !empty( $buttonsize ) ) { echo " ".$buttonsize;  }
                    if ( !empty( $buttonstyle ) ) { echo " ".$buttonstyle;  }
            ?>" href="<?php echo $buttonurl; ?>"><?php echo $buttontext; ?></a>
            </div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

        $instance['buttontext'] =  $new_instance['buttontext'];
        $instance['buttonurl'] =  $new_instance['buttonurl'];
        $instance['buttonsize'] =  $new_instance['buttonsize'];
        $instance['buttonstyle'] =  $new_instance['buttonstyle'];

		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,
                        array( 'buttontext' => '', 'buttonurl' => '', 'buttonsize' => '' , 'buttonstyle' => '' ) );
		$buttontext = esc_textarea($instance['buttontext']);
		$buttonurl = esc_textarea($instance['buttonurl']);
		$buttonsize = esc_textarea($instance['buttonsize']);
		$buttonstyle = esc_textarea($instance['buttonstyle']);
?>
		<p>
            <label for="<?php echo $this->get_field_id('buttontext'); ?>"><?php _e('Button Text','bsc'); ?>:</label>		        <input class="widefat" id="<?php echo $this->get_field_id('buttontext'); ?>" name="<?php echo $this->get_field_name('buttontext'); ?>" type="text" value="<?php echo esc_attr($buttontext); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('buttonurl'); ?>"><?php _e('Button URL','bsc'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('buttonurl'); ?>" name="<?php echo $this->get_field_name('buttonurl'); ?>" type="text" value="<?php echo esc_attr($buttonurl); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'buttonsize' ); ?> ">
                <?php _e('Button Size', 'bsc'); ?>:
            </label>
            <select id="<?php echo $this->get_field_id( 'buttonsize' ); ?>" name="<?php echo $this->get_field_name( 'buttonsize' ); ?>">
                <option value="btn-lg" <?php
                    if($instance['buttonsize'] == "btn-lg")
                        echo 'selected="selected"';
                ?>><?php _e('Large','bsc');?></option>

                <option value="btn-md" <?php
                    if($instance['buttonsize'] == "btn-md")
                        echo 'selected="selected"';
                ?>><?php _e('Medium','bsc');?></option>

                <option value="btn-sm" <?php
                    if($instance['buttonsize'] == "btn-sm")
                        echo 'selected="selected"';
                ?>><?php _e('Small','bsc');?></option>

                <option value="btn-xs" <?php
                    if($instance['buttonsize'] == "btn-xs")
                        echo 'selected="selected"';
                ?>><?php _e('Extra Small','bsc');?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'buttonstyle' ); ?> ">
                <?php _e('Button Style', 'bsc'); ?>:
            </label>
            <select id="<?php echo $this->get_field_id( 'buttonstyle' ); ?>" name="<?php echo $this->get_field_name( 'buttonstyle' ); ?>">
                <option value="btn-default" <?php
                    if($instance['buttonstyle'] == "btn-default")
                        echo 'selected="selected"';
                ?>><?php _e('Default','bsc');?></option>

                <option value="btn-primary" <?php
                    if($instance['buttonstyle'] == "btn-primary")
                        echo 'selected="selected"';
                ?>><?php _e('Primary','bsc');?></option>

                <option value="btn-success" <?php
                    if($instance['buttonstyle'] == "btn-success")
                        echo 'selected="selected"';
                ?>><?php _e('Success','bsc');?></option>

                <option value="btn-info" <?php
                    if($instance['buttonstyle'] == "btn-info")
                        echo 'selected="selected"';
                ?>><?php _e('Info','bsc');?></option>

                <option value="btn-warning" <?php
                    if($instance['buttonstyle'] == "btn-warning")
                        echo 'selected="selected"';
                ?>><?php _e('Warning','bsc');?></option>

                <option value="btn-danger" <?php
                    if($instance['buttonstyle'] == "btn-danger")
                        echo 'selected="selected"';
                ?>><?php _e('Danger','bsc');?></option>
            </select>
        </p>

		<?php
		}
		}


/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */

add_action( 'widgets_init', create_function( '', 'register_widget( "BSC_Button" );' ) );
