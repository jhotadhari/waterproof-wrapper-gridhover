<?php
/*
	grunt.concat_in_order.declare('init');
*/


// load_plugin_textdomain
function wpwqgh_load_textdomain(){
	
	load_plugin_textdomain(
		'wpwq-gh',
		false,
		dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
	);
}
add_action( 'plugins_loaded', 'wpwqgh_load_textdomain' );


?>