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

/**
 * Function that creates the widget
 *
 * @return void
 */
function widget_wsg_childmenu() {
	register_widget( 'WSG_ChildMenu' );
}
add_action( 'widgets_init', 'widget_wsg_childmenu' );

/**
 * Class for the widget
 */
class WSG_ChildMenu extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'widget_childmenu',
			'description' => __( 'It gives you a menu with child pages.', 'bsc' ),
		);
		$control_ops = array(
			'width'  => 400,
			'height' => 350,
		);
		parent::__construct( 'childmenutext', __( 'Menu Child Pages', 'gsw' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$ordermenu = apply_filters( 'widget_ordermenu', empty( $instance['ordermenu'] ) ? '' : $instance['ordermenu'], $instance );

		echo $before_widget;

		$wpseo_childmenu = get_option( 'wpseo_childmenu' );

		global $post;

		$current_post_type = get_post_type( $post );
		$post_parent       = $post->post_parent;
		$tmp_post          = $post;

		if ( $post_parent == 0 ) {
			$args = array(
				'order'          => 'ASC',
				'posts_per_page' => -1,
				'orderby'        => $ordermenu,
				'post_type'      => $current_post_type,
				'post_parent'    => $post->ID,
			);
		} else {
			$args = array(
				'order'          => 'ASC',
				'posts_per_page' => -1,
				'orderby'        => $ordermenu,
				'post_type'      => $current_post_type,
				'post_parent'    => $post_parent,
			);
		}

		$myposts = get_posts( $args );

		if ( $myposts ) {
			echo '<ul class="menuchild nav nav-pills">';
			foreach ( $myposts as $post ) :
				setup_postdata( $post );
				echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
			endforeach;
			$post = $tmp_post;
			setup_postdata( $post );
			echo '</ul>';
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['ordermenu'] = $new_instance['ordermenu'];
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array( 'ordermenu' => '' )
		);
		?>
		<p><?php _e( 'Select the options for this widget.', 'gsw' ); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ordermenu' ); ?> ">
				<?php _e( 'Order Menu', 'bsc' ); ?>:
			</label>
			<select id="<?php echo $this->get_field_id( 'ordermenu' ); ?>" name="<?php echo $this->get_field_name( 'ordermenu' ); ?>">

				<option value="menu_order" 
				<?php
				if ( $instance['ordermenu'] == 'menu_order' ) {
					echo 'selected="selected"';
				}
				?>
				><?php _e( 'Menu Order', 'gsw' ); ?></option>

				<option value="title" 
				<?php
				if ( $instance['ordermenu'] == 'title' ) {
					echo 'selected="selected"';
				}
				?>
				><?php _e( 'Title', 'gsw' ); ?></option>
			</select>
		</p>
		<?php
	}
} //from class
