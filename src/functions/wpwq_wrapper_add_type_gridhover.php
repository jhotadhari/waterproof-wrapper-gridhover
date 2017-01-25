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
			'desc' => __('A grid layout wrapper. Uses pure CSS3 effects on hover.<br>
				Inspired by that <a title="Original Hover Effects with CSS3" target="_blank" href="https://tympanus.net/codrops/2011/11/02/original-hover-effects-with-css3/">Codrops Article</a>, thanks for sharing.<br>
				The First 5 styles are supported currently.','wpwq-gh'),
			'args' => array(
				'has_link' => array(
					'accepts' => 'bool', 
					'default' => 'false', 
					'desc' => __('Object should be linked?','wpwq-gh')
					),
				'style' => array(
					'accepts' => 'list of int', 
					'default' => '1', 
					'desc' => __('Choose styles, comma seperated list of numeric ids','wpwq-gh')
					),
				'style_order' => array(
					'accepts' => '"rand"|"asc"', 
					'default' => 'rand', 
					'desc' => __('"rand" or "asc".','wpwq-gh')
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