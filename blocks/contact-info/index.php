<?php

defined( 'ABSPATH' ) || exit;

add_action( 'enqueue_block_editor_assets', 'wsg_contact_info_enqueue_block_editor_assets' );

function wsg_contact_info_enqueue_block_editor_assets() {
	wp_enqueue_script(
		'wsg-contact-info',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'underscore' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
	);
}

add_action( 'enqueue_block_assets', 'wsg_contact_info_enqueue_block_assets' );

function wsg_contact_info_enqueue_block_assets() {
	wp_enqueue_style(
		'wsg-contact-info',
		plugins_url( 'style.css', __FILE__ ),
		array( 'wp-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
	);
}
