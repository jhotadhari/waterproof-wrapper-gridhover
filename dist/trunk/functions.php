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
<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_gridhover_single');
	grunt.concat_in_order.require('init');
*/

class Wpwq_wrapper_gridhover_single extends Wpwq_wrapper_single {
	
	function __construct( $name = null, $query_single_obj = null , $args = null, $args_single = null, $single_count = null ) {
		parent::__construct( $name, $query_single_obj , $args, $args_single, $single_count);
		$this->set_inner( $query_single_obj );
	}
		
	protected function set_inner( $query_single_obj ) {
		
		$is_linked = ( array_key_exists('has_link', $this->args ) 
			&& $this->args['has_link'] == 'true' 
			&& strlen($query_single_obj['str_link']) > 0
			&& strlen($query_single_obj['link']) > 0 
			? true 
			: false );
		
		$style = ( array_key_exists('style', $this->args ) && strlen($this->args['style']) > 0 ? $this->args['style'] : '1' );
		$style_order = ( array_key_exists('style_order', $this->args ) && strlen($this->args['style_order']) > 0 ? $this->args['style_order'] : 'rand' );


		$styles = range(1, 5);
		
		$styles = array_intersect( $styles, explode(',',$style) );
		
		switch ($style_order) {
			case 'asc':
				$single_count = $this->args_single['single_count'];
				$i = 0;			
				do {
					$style = $single_count - ( $i * count($styles) );
					$i++;
				} while ( $style > count($styles) );
				break;
			case 'rand':
				$style = $styles[array_rand( $styles )];
			default:
				$style = $styles[array_rand( $styles )];
		}
		
		$r = '';
		
		$item_classes = array();
		$item_classes[] = 'wpwq-query-wrapper-item';	// selector for js
		$item_classes[] = 'post-' . $query_single_obj['id'];	// selector for js
		$item_classes[] = 'view';
		$item_classes[] = 'view-' . $style;
		$item_classes[] = $this->args_single['single_count'] % $this->args['per_row'] == 0 ? 'last' : '' ;
		$item_classes = array_diff($item_classes, array(''));
		$item_classes_attr = count($item_classes) > 0 ? ' class="' . implode( ' ', $item_classes ). '"' : '';
		
		$r .= '<div ' . $item_classes_attr . '>';

			$target = apply_filters('wpwq_single_obj_link_target', '', $query_single_obj['link']);
			$r .= $is_linked ? '<a href="' . $query_single_obj['link'] . '" class="info"' . $target . '>' : '' ;
			$r .= '<div class="view-inner hovertrigger">';		// hovertrigger: selector for js
			
				if ( strlen($query_single_obj['image_url']) > 0) {
					$image_url = $query_single_obj['image_url'];
				} elseif ( !empty(wpwq_get_option('gridhover_default_imgs')) ) {
					$image_url = wp_get_attachment_image_src( array_rand( wpwq_get_option('gridhover_default_imgs')), 'thumbnail' )[0];
				} else {
					$image_url = '#';	// ???
				}
				
				$r .= '<img src="' . $image_url . '" />';
				
				switch ($style) {
					case '2':
						$r .= '<div class="mask">';
						$r .= '</div>';
						$r .= '<div class="content">';
							$r .= '<h2>' . $query_single_obj['str_title'] . '</h2>';
							$r .= $query_single_obj['str_inner'];
						$r .= '</div>';
						
						break;						
					default:
						$r .= '<div class="mask">';
							$r .= '<h2>' . $query_single_obj['str_title'] . '</h2>';
							$r .= $query_single_obj['str_inner'];
						$r .= '</div>';


				}
			
			$r .= '</div>';
			$r .= $is_linked ? '</a>' : '' ;
			
		$r .= '</div>';
		
		$this->inner = $r;
		
	}
	
}

?>
<?php
/*
	grunt.concat_in_order.declare('Wpwqgh_defaults');
	grunt.concat_in_order.require('init');
*/


class Wpwqgh_defaults {


	protected $defaults = array();

	public function add_default( $arr ){
		$defaults = $this->defaults;
		$this->defaults = array_merge( $defaults , $arr);
	}
	
	public function get_default( $key ){
		if ( array_key_exists($key, $this->defaults) ){
			return $this->defaults[$key];

		}
			return null;
	}


}



function wpwqgh_init_defaults(){
	global $wpwqgh_defaults;
	
	$wpwqgh_defaults = new Wpwqgh_defaults();
	
}
add_action( 'admin_init', 'wpwqgh_init_defaults', 1 );
add_action( 'init', 'wpwqgh_init_defaults', 1 );



?>
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
<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_gridhover');
	grunt.concat_in_order.require('init');

	grunt.concat_in_order.declare('Wpwq_wrapper_gridhover_single');
	grunt.concat_in_order.require('wpwq_wrapper_add_type_gridhover');
	grunt.concat_in_order.require('wpwqgh_wrapper_gridhover_defaults');
	grunt.concat_in_order.require('wpwq_wrapper_gridhover_options');
*/

class Wpwq_wrapper_gridhover extends Wpwq_wrapper {
	
	public $per_row;
	
	function __construct( $query_obj = null, $objs = null, $args = null ) {
		parent::__construct( $query_obj, $objs, $args );

		$this->set_name( 'gridhover' );
		
		add_action( 'wp_footer', array( $this, 'styles_scripts_frontend' ), 1 );

		$this->set_wrapper_open();
		$this->set_wrapper_close();
		$this->set_wrapper_inner();
	}

	protected function set_wrapper_open() {

		$per_row = false;
		if ( array_key_exists( 'per_row_max', $this->args )
			&& strlen($this->args['per_row_max']) > 0
			&& is_numeric( $this->args['per_row_max'] )
			&& $this->args['per_row_max'] > 0 
			&& $this->args['per_row_max'] <= 10			
		) {		
			$per_row = $this->args['per_row_max'];	//4
			while( $this->args['count_total'] % $per_row != 0 ) {
				$per_row--;
			}
		}
		
		if ( array_key_exists( 'per_row', $this->args )
			&& strlen($this->args['per_row']) > 0
			&& is_numeric( $this->args['per_row'] )
			&& $this->args['per_row'] > 0 
			&& $this->args['per_row'] <= 10			
		) {
			$per_row = min( $this->args['count_total'], $this->args['per_row']);
		}
		
		$per_row = $per_row ? $per_row : min( $this->args['count_total'], '4' );
		$this->args['per_row'] = $per_row;
		
		$unique = ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) > 0 ? ' ' . $this->args['unique'] . '-unique' : '' );
		$this->wrapper_open = '<div class="wpwq-query-wrapper clearfix gridhover' . $unique . ' per-row-' . $per_row . '">';

	}
	protected function set_wrapper_close() {
		$this->wrapper_close = '</div>';
	}
	
	
	public function styles_scripts_frontend() {
		
		$enqueue_jscss = wpwq_get_option( $this->type_name . '_' . 'enqueue_jscss', array(
			'wpwqgh_style'
		));
		
		if ( in_array( 'wpwqgh_style', $enqueue_jscss )){	
			wp_enqueue_style( 'wpwqgh_style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
		}
		
		
		if ( get_template_directory_uri() != get_stylesheet_directory_uri() ){
			// childtheme exists
			if ( file_exists( get_template_directory() . '/wpwq/wpwqgh_style.css' ) ){
				wp_enqueue_style( 'wpwqgh_style_theme', get_template_directory_uri() . '/wpwq/wpwqgh_style.css' );

			}
			if ( file_exists( get_stylesheet_directory() . '/wpwq/wpwqgh_style.css' ) ){
				wp_enqueue_style( 'wpwqgh_style_childtheme', get_stylesheet_directory_uri() . '/wpwq/wpwqgh_style.css' );

			}
		} else {
			// childtheme doesn't exists
			if ( file_exists( get_template_directory() . '/wpwq/wpwqgh_style.css' ) ){
				
				wp_enqueue_style( 'wpwqgh_style_theme', get_template_directory_uri() . '/wpwq/wpwqgh_style.css' );

			}
		}
		
		wp_register_script( 'wpwqgh_script', plugin_dir_url( __FILE__ ) . 'js/script.min.js', array('jquery','jquery-ui-accordion') , false , true);
	}	
	
	
	protected function set_wrapper_inner() {
		$return = '';
		
		$i = 1;
		foreach ( $this->query_prepared as $query_single_obj ){
			$wpwq_wrapper_gridhover_single = new Wpwq_wrapper_gridhover_single( $this->get_name(), $query_single_obj, $this->args, $this->get_args_single(), $i );
			$return .= $wpwq_wrapper_gridhover_single->get_inner();
			$i++;
		}
		
		$this->wrapper_inner = $return;
	}
}
	





?>