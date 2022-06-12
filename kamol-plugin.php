<?php
/*
Plugin Name: AAA Kamol WooCommerce Addons
Plugin URI: #
Description: Countdown plugin is an nice tool to create and insert countdown timers into your posts/pages and widgets .
Version: 1.0.0
Author: enigma
Author URI: #
License: GPL3 http://www.gnu.org/licenses/gpl-3.0.html
*/
define('KAMOL_URL', trailingslashit(plugins_url('/', __FILE__)));

include_once 'helpers.php';

add_action( 'plugins_loaded', 'kamol_init_fields' );
function kamol_init_fields() {
	if ( is_admin() ) {
		include_once 'custom-fields/admin/kamol-custom-fields.php';
	} else {
		include_once 'custom-fields/public/kamol-custom-fields-display.php';
	}
}