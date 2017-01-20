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
		
		$this->parse_data();
		
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
		
		$unique = ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) > 0 ? ' ' . wpwq_slugify($this->args['unique']) . '-unique' : '' );
		$this->wrapper_open = '<div class="wpwq-query-wrapper clearfix gridhover' . $unique . ' per-row-' . $per_row . '">';

	}
	protected function set_wrapper_close() {
		$this->wrapper_close = '</div>';
	}
	
	protected function parse_data() {
		/*
		global $wpwqgh_localize;
		global $wpwqgh_defaults;

		$acc_options = wpwq_get_option( $this->type_name . '_' . 'acc_options', $wpwqgh_defaults->get_default( 'acc_options' ));
		$jsonStr = strip_tags(str_replace( ' ', '', $acc_options));
		$acc_options = ( null !== json_decode( $jsonStr, true ) ? json_decode( $jsonStr, true ) : array() );
		
		$options = array(
			'global' => array(
				'acc_options' => $acc_options
			)
		);
		
		if ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) ) {
			$unique = wpwq_slugify($this->args['unique']);
			
			$options[$unique]['acc_options'] = ( array_key_exists('acc_options', $this->args) ? $this->args['acc_options'] : array() );
		}
		
		$wpwqgh_localize->add_datas( $options );
		*/

	}
	
	public function styles_scripts_frontend() {
		
		$enqueue_jscss = wpwq_get_option( $this->type_name . '_' . 'enqueue_jscss', array(
			// 'jquery_ui_accordion_js',
			// 'jquery_ui_css',
			'wpwqgh_style'
		));
		/*
		if ( in_array( 'jquery_ui_css', $enqueue_jscss )){	
			wp_enqueue_style( 'jquery_ui_css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css' );
		}
		*/
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
		/*
		if ( in_array( 'jquery_ui_accordion_js', $enqueue_jscss )){	
			wp_enqueue_script('jquery-ui-accordion');
		}
		*/
		wp_register_script( 'wpwqgh_script', plugin_dir_url( __FILE__ ) . 'js/script.min.js', array('jquery','jquery-ui-accordion') , false , true);
	}	
	public function scripts_frontend_print() {
		/*
		global $wpwqgh_localize;
		
		$parse_data = $wpwqgh_localize->get_datas();
		wp_localize_script( 'wpwqgh_script', 'Wpwq_wrapper_' . $this->type_name, $parse_data );
		wp_print_scripts('wpwqgh_script');
		*/
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