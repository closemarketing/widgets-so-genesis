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
function widget_wsg_contactinfo() {
	register_widget( 'WSG_Contact_Info' );
}
add_action( 'widgets_init', 'widget_wsg_contactinfo' );

/**
 * Class for the widget
 */
class WSG_Contact_Info extends WP_Widget {

	function __construct() {
		$widget_ops  = array('classname' => 'widget_contact', 'description' => __('Adds contact info in a widget.', 'widgets-so-genesis'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('contact_widget', __('Contact Info', 'widgets-so-genesis'), $widget_ops, $control_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$contact_company = apply_filters('widget_contact_company', empty($instance['contact_company']) ? '' : $instance['contact_company'], $instance);
		$contact_dir1    = apply_filters('widget_contact_dir1', empty($instance['contact_dir1']) ? '' : $instance['contact_dir1'], $instance);
		$contact_dir2    = apply_filters('widget_contact_dir2', empty($instance['contact_dir2']) ? '' : $instance['contact_dir2'], $instance);
		$contact_zip     = apply_filters('widget_contact_zip', empty($instance['contact_zip']) ? '' : $instance['contact_zip'], $instance);
		$contact_city    = apply_filters('widget_contact_city', empty($instance['contact_city']) ? '' : $instance['contact_city'], $instance);
		$contact_state   = apply_filters('widget_contact_state', empty($instance['contact_state']) ? '' : $instance['contact_state'], $instance);
		$contact_phone   = apply_filters('widget_contact_phone', empty($instance['contact_phone']) ? '' : $instance['contact_phone'], $instance);
		$contact_email   = apply_filters('widget_contact_email', empty($instance['contact_email']) ? '' : $instance['contact_email'], $instance);
		$contact_desc    = apply_filters('widget_contact_desc', empty($instance['contact_desc']) ? '' : $instance['contact_desc'], $instance);

		echo $before_widget;?>

            <div class="companyinfo" itemscope itemtype="http://schema.org/LocalBusiness">
              <h3 class="widget-title"><span itemprop="name"><?php echo $contact_company; ?></span></h3>

              <?php if ($contact_desc) {?>
                  <span itemprop="description"><?php echo $contact_desc; ?></span>
              <?php }?>
              <?php if ($contact_dir1) {?>
              <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                <i class="fa fa-map-marker"></i>
                <span itemprop="streetAddress">
                    <?php echo $contact_dir1; ?></br><?php echo $contact_dir2; ?>
                </span>
                <br/>
                <span itemprop="postalCode"><?php echo $contact_zip; ?> </span>
                <span itemprop="addressLocality"><?php echo $contact_city; ?></span>
                <span itemprop="addressRegion">(<?php echo $contact_state; ?>)</span>
              </div>
              <?php }?>
              <?php if ($contact_phone) {?>
                  <i class="fa fa-phone-square"></i>
                  <?php _e('Phone', 'widgets-so-genesis');?>: <span itemprop="telephone"><?php echo $contact_phone; ?></span><br/>
              <?php }?>
              <?php if ($contact_email) {?>
              <i class="fa fa-envelope-o"></i>
              <?php _e('E-mail', 'widgets-so-genesis');?>:
              <a href="mailto:<?php echo $contact_email; ?>">
                <span itemprop="email"><?php echo $contact_email; ?></span>
              </a>
              <?php }?>
            </div>

        <?php
echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['contact_company'] = $new_instance['contact_company'];
		$instance['contact_dir1']    = $new_instance['contact_dir1'];
		$instance['contact_dir2']    = $new_instance['contact_dir2'];
		$instance['contact_zip']     = $new_instance['contact_zip'];
		$instance['contact_city']    = $new_instance['contact_city'];
		$instance['contact_state']   = $new_instance['contact_state'];
		$instance['contact_phone']   = $new_instance['contact_phone'];
		$instance['contact_email']   = $new_instance['contact_email'];
		$instance['contact_desc']    = $new_instance['contact_desc'];

		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance,
			array('contact_company' => '',
				'contact_dir1'          => '',
				'contact_dir2'          => '',
				'contact_zip'           => '',
				'contact_city'          => '',
				'contact_state'         => '',
				'contact_phone'         => '',
				'contact_email'         => '',
				'contact_desc'          => '',
			));
		$contact_company = esc_textarea($instance['contact_company']);
		$contact_dir1    = esc_textarea($instance['contact_dir1']);
		$contact_dir2    = esc_textarea($instance['contact_dir2']);
		$contact_zip     = esc_textarea($instance['contact_zip']);
		$contact_city    = esc_textarea($instance['contact_city']);
		$contact_state   = esc_textarea($instance['contact_state']);
		$contact_phone   = esc_textarea($instance['contact_phone']);
		$contact_email   = esc_textarea($instance['contact_email']);
		$contact_desc    = esc_textarea($instance['contact_desc']);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('contact_company'); ?>"><?php _e('Contact Name', 'widgets-so-genesis');?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('contact_company'); ?>" name="<?php echo $this->get_field_name('contact_company'); ?>" type="text" value="<?php echo esc_attr($contact_company); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_dir1'); ?>"><?php _e('Address info 1', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_dir1'); ?>" name="<?php echo $this->get_field_name('contact_dir1'); ?>" type="text" value="<?php echo esc_attr($contact_dir1); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_dir2'); ?>"><?php _e('Address info 2', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_dir2'); ?>" name="<?php echo $this->get_field_name('contact_dir2'); ?>" type="text" value="<?php echo esc_attr($contact_dir2); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_zip'); ?>"><?php _e('ZIP', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_zip'); ?>" name="<?php echo $this->get_field_name('contact_zip'); ?>" type="text" value="<?php echo esc_attr($contact_zip); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_city'); ?>"><?php _e('City', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_city'); ?>" name="<?php echo $this->get_field_name('contact_city'); ?>" type="text" value="<?php echo esc_attr($contact_city); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_state'); ?>"><?php _e('State', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_state'); ?>" name="<?php echo $this->get_field_name('contact_state'); ?>" type="text" value="<?php echo esc_attr($contact_state); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_phone'); ?>"><?php _e('Phone', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_phone'); ?>" name="<?php echo $this->get_field_name('contact_phone'); ?>" type="text" value="<?php echo esc_attr($contact_phone); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_email'); ?>"><?php _e('Email', 'widgets-so-genesis');?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('contact_email'); ?>" name="<?php echo $this->get_field_name('contact_email'); ?>" type="text" value="<?php echo esc_attr($contact_email); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('contact_desc'); ?>"><?php _e('Contact Description', 'widgets-so-genesis');?>:</label>
        <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('contact_desc'); ?>" name="<?php echo $this->get_field_name('contact_desc'); ?>"><?php echo $contact_desc; ?></textarea>
        </p>

        <?php
}
}

