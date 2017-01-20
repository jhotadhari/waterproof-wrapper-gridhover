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