<?php
/*
	grunt.concat_in_order.declare('wpwq_wrapper_add_type_gridhover');
	grunt.concat_in_order.require('init');
*/

/**
* Add type name to the $wpwq_wrapper_types object
*/
function wpwq_wrapper_add_type_gridhover(){
	global $wpwq_wrapper_types;
	$wpwq_wrapper_types->add_type( array(
		'gridhover' => array(
			'desc' => __('???','wpwq-gh'),
			'args' => array(
				'has_link' => array(
					'accepts' => 'bool', 
					'default' => 'false', 
					'desc' => __('Object should be linked?','wpwq-gh')
					),
				'style' => array(
					'accepts' => 'int|"rand"|"asc"', 
					'default' => 'rand', 
					'desc' => __('Choose a style by numeric id, or use "rand" or "asc".','wpwq-gh')
					),
				'per_row_max' => array(
					'accepts' => 'int', 
					'default' => '5', 
					'desc' => __('Maximal number of items per row? max 10','wpwq-gh')
					),
				'per_row' => array(
					'accepts' => 'int', 
					'default' => '', 
					'desc' => __('Overrides "per_row_max". How many itmes per row? max 10','wpwq-gh')
					),
			)
		)
	) );
}
add_action( 'admin_init', 'wpwq_wrapper_add_type_gridhover' );

add_action( 'init', 'wpwq_wrapper_add_type_gridhover' );


?>