<?php
/*
Plugin Name: Widgets for Genesis Framework
Plugin URI: https://github.com/closemarketing/genesis-so-widgets
Description: Widgets Page Builder SiteOrigin for Genesis Framework
Author: closemarketing, davidperez, afortunato
Author URI: https://www.closemarketing.es
Version: 0.6.1
Text Domain: widgets-so-genesis
Domain Path: /languages
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('ABSPATH') or exit;

//Loads translation
load_plugin_textdomain('widgets-so-genesis', false, dirname(plugin_basename(__FILE__)) . '/languages/');

/* # Include Widgets
---------------------------------------------------------------------------------------------------- */

//* Button Android
require_once plugin_dir_path(__FILE__) . 'widgets/buttand.php';

//* Button iOS
require_once plugin_dir_path(__FILE__) . 'widgets/buttios.php';

//* Button iOS
require_once plugin_dir_path(__FILE__) . 'widgets/buttoncta.php';

//* Child pages menu
require_once plugin_dir_path(__FILE__) . 'widgets/childmenu.php';

//* Contact Info
require_once plugin_dir_path(__FILE__) . 'widgets/contactinfo.php';

//* Embed Object/Video
require_once plugin_dir_path(__FILE__) . 'widgets/embed.php';

//* Last Posts with image
require_once plugin_dir_path(__FILE__) . 'widgets/latestimgposts.php';

//* Social Icons from Yoast
require_once plugin_dir_path(__FILE__) . 'widgets/social-icons.php';

//* WooCommerce Category with Images
require_once plugin_dir_path(__FILE__) . 'widgets/woocatimg.php';
