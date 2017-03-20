<?php
/*
Plugin Name: Widgets for Page Builder SiteOrigin and Genesis Framework
Plugin URI: https://github.com/closemarketing/genesis-so-widgets
Description: Widgets Page Builder SiteOrigin for Genesis Framework
Author: closemarketing
Author URI: https://www.closemarketing.es
Version: 0.6
Text Domain: widgets-so-genesis
Domain Path: /languages
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) or exit;


//Loads translation
load_plugin_textdomain('widgets-so-genesis', false, dirname( plugin_basename( __FILE__ ) ). '/languages/');

//Widgets
foreach ( glob( dirname( __FILE__ ) . '/widgets/*.php' ) as $file ) { include_once $file; }