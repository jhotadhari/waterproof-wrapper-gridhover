<?php
/*
	grunt.concat_in_order.declare('init');
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// load_plugin_textdomain
function wpwqgh_load_textdomain(){
	
	load_plugin_textdomain(
		'wpwq-gh',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'init', 'wpwqgh_load_textdomain' );


?>