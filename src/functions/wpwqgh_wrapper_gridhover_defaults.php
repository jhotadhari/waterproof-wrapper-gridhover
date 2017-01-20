<?php
/*
	grunt.concat_in_order.declare('wpwqgh_wrapper_gridhover_defaults');
	grunt.concat_in_order.require('init');
	grunt.concat_in_order.require('Wpwqgh_defaults');
*/


/**
* Add related defaults to the global $wpwqgh_defaults object
*/
function wpwqgh_add_defaults_wrapper_gridhover(){
	global $wpwqgh_defaults;
		
	// define name
	$type_name = 'gridhover';
		
	$wpwqgh_defaults->add_default( array(
		'wrapper_' . $type_name . '_' . 'default_image' => ''
	));
}
add_action( 'admin_init', 'wpwqgh_add_defaults_wrapper_gridhover', 2 );
add_action( 'init', 'wpwqgh_add_defaults_wrapper_gridhover', 2 );



?>