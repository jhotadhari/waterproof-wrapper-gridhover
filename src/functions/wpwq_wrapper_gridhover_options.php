<?php
/*
	grunt.concat_in_order.declare('wpwq_wrapper_gridhover_options');
	grunt.concat_in_order.require('init');
*/

// Add related defaults to the global $tarp_defaults object
function wpwqgh_add_defaults(){
	global $wpwqgh_defaults;
	
}
add_action( 'admin_init', 'wpwqgh_add_defaults', 2 );
add_action( 'init', 'wpwqgh_add_defaults', 2 );

function wpwqgh_options_cb( $cmb ) {
	global $wpwqgh_defaults;
	global $wpwq_wrapper_types;
	
	// define name
	$type_name = 'gridhover';
	// get type_desc 
	$type_desc = $wpwq_wrapper_types->get_types( null, $type_name)[$type_name];
	
	$classes = 'wpwq-wrapper wrapper-gridhover';

	$cmb->add_field( array(
		'name' => __('Gridhover Wrapper', 'wpwq-gh'),
		'id' => $type_name . '_' . 'title',
		'desc' => '<span class="font-initial">' . __( $type_desc['desc'] , 'wpwq-gh') . '</span>',
		'type'    => 'title',
		'classes' => $classes,
	) );
	
	$cmb->add_field( array(
		'name' => __('Default Images', 'wpwq-gh'),
		'id' => $type_name . '_' . 'default_imgs',
		'desc' => __( '???' , 'wpwq-gh'),
		'type'    => 'file_list',
		'options' => array(
			'url' => false,
			'add_upload_file_text' => 'Add Image',
		),
		'query_args'   => array(
			'type' => 'image',
		),
		'classes' => $classes,
	) );
	
	$cmb->add_field( array(
		'name'    => 'Enqueue Frontend styles and scripts',
		'desc'    => __('Uncheck these if you want to load them your own way.','wpwq-jquiacc') . '<br>'
			. '<span class="font-initial">' . sprintf(__('If your Theme or Childtheme has a folder "%s" with file "%s" it will be enqueued at last.','wpwq-gh'), 'wpwq', 'wpwqgh_style.css') . '</span>'
		,
		'id'      => $type_name . '_' . 'enqueue_jscss',
		'type'    => 'multicheck',
		'default' => array(
			'wpwqgh_style'
		),
		'options' => array(
			'wpwqgh_style' => 'Plugin style wpwqgh_style'
		),
		'classes' => $classes,
	) );	
	
	
}
add_action('wpwq_options', 'wpwqgh_options_cb', 10, 1 );
?>