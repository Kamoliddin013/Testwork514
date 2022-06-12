<?php

function kamol_admin_script_styles(){
	wp_enqueue_script( 'admin_kamol_script', KAMOL_URL . '/assets/js/admin.js', array('jquery'), rand(), true );
	wp_enqueue_style( 'admin_kamol_style', KAMOL_URL . 'assets/css/admin.css', '', rand() );
}
add_action('admin_enqueue_scripts', 'kamol_admin_script_styles');

function my_admin_scripts() {
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
}

function my_admin_styles() {
	wp_enqueue_style( 'thickbox' );
}

add_action( 'admin_print_scripts', 'my_admin_scripts' );
add_action( 'admin_print_styles', 'my_admin_styles' );
