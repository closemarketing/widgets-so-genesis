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

class BSC_Social extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_social', 'description' => __('Adds social icons with URLs included in Yoast SEO', 'bsc'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('socialtext', __('Social Icons','bsc'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$iconsize = apply_filters( 'widget_iconsize', empty( $instance['iconsize'] ) ? '' : $instance['iconsize'], $instance );
		$iconstyle = apply_filters( 'widget_iconstyle', empty( $instance['iconstyle'] ) ? '' : $instance['iconstyle'], $instance );
        
		echo $before_widget; 
        
        $wpseo_social = get_option('wpseo_social'); 
        
        

        if($wpseo_social['facebook_site'])
            echo '<a href="'.$wpseo_social['facebook_site'].'"><i class="fa '.$iconsize.' fa-facebook'.$iconstyle.'" rel="nofollow"></i></a>';
        if($wpseo_social['twitter_site'])
            echo '<a href="https://twitter.com/'.$wpseo_social['twitter_site'].'"><i class="fa '.$iconsize.' fa-twitter'.$iconstyle.'" rel="nofollow"></i></a>';
        if($wpseo_social['linkedin_url'])
            echo '<a href="'.$wpseo_social['linkedin_url'].'"><i class="fa '.$iconsize.' fa-linkedin'.$iconstyle.'" rel="nofollow"></i></a>';
        if($wpseo_social['instagram_url'])
            echo '<a href="'.$wpseo_social['instagram_url'].'"><i class="fa '.$iconsize.' fa-instagram'.$iconstyle.'" rel="nofollow"></i></a>';
        if($wpseo_social['google_plus_url'])
            echo '<a href="'.$wpseo_social['google_plus_url'].'"><i class="fa '.$iconsize.' fa-google-plus'.$iconstyle.'" rel="nofollow"></i></a>';
        if($wpseo_social['youtube_url'])
            echo '<a href="'.$wpseo_social['youtube_url'].'"><i class="fa '.$iconsize.' fa-youtube'.$iconstyle.'" rel="nofollow"></i></a>';
        if($wpseo_social['pinterest_url'])
            echo '<a href="'.$wpseo_social['pinterest_url'].'"><i class="fa '.$iconsize.' fa-pinterest'.$iconstyle.'" rel="nofollow"></i></a>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

        $instance['iconsize'] =  $new_instance['iconsize'];
        $instance['iconstyle'] =  $new_instance['iconstyle'];

		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,
                        array( 'iconsize' => '' , 'iconstyle' => '' ) );
		$iconsize = esc_textarea($instance['iconsize']);
		$iconstyle = esc_textarea($instance['iconstyle']);
    ?>
        <p><?php _e('It uses the URLs defined in Yoast SEO / Social tab.','bsc');?></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'iconsize' ); ?> ">
                <?php _e('Icon Size', 'bsc'); ?>:
            </label>
            <select id="<?php echo $this->get_field_id( 'iconsize' ); ?>" name="<?php echo $this->get_field_name( 'iconsize' ); ?>">

                <option value="fa-5x" <?php
                    if($instance['iconsize'] == "fa-5x")
                        echo 'selected="selected"';
                ?>><?php _e('Extra Large','bsc');?> 5x</option>

                <option value="fa-4x" <?php
                    if($instance['iconsize'] == "fa-4x")
                        echo 'selected="selected"';
                ?>><?php _e('Large','bsc');?> 4x</option>

                <option value="fa-3x" <?php
                    if($instance['iconsize'] == "fa-3x")
                        echo 'selected="selected"';
                ?>><?php _e('Medium','bsc');?> 3x</option>

                <option value="fa-2x" <?php
                    if($instance['iconsize'] == "fa-2x")
                        echo 'selected="selected"';
                ?>><?php _e('Small','bsc');?> 2x</option>

                <option value="fa-lg" <?php
                    if($instance['iconsize'] == "fa-lg")
                        echo 'selected="selected"';
                ?>><?php _e('Extra Small','bsc');?> 1x</option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'iconstyle' ); ?> ">
                <?php _e('Icon Style', 'bsc'); ?>:
            </label>
            <select id="<?php echo $this->get_field_id( 'iconstyle' ); ?>" name="<?php echo $this->get_field_name( 'iconstyle' ); ?>">
                <option value="" <?php
                    if($instance['iconstyle'] == "")
                        echo 'selected="selected"';
                ?>><?php _e('Simple','bsc');?></option>

                <option value="-square" <?php
                    if($instance['iconstyle'] == "-square")
                        echo 'selected="selected"';
                ?>><?php _e('Square','bsc');?></option>
            </select>
        </p>

		<?php
		}
} //from class


/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */

add_action( 'widgets_init', create_function( '', 'register_widget( "BSC_Social" );' ) );