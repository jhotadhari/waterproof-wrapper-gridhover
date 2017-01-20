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
		
		$is_linked = ( array_key_exists('has_link', $this->args ) && $this->args['has_link'] == 'true' && strlen($query_single_obj['str_link']) > 0 ? true : false );
		
		$styles = range(1, 5);
		$style = ( array_key_exists('style', $this->args ) && strlen($this->args['style']) > 0 ? $this->args['style'] : 'rand' );
		if ( $style == 'rand' ){
			$style = $styles[array_rand( $styles )];
		} else if ( $style == 'asc' ){
			$single_count = $this->args_single['single_count'];
			$i = 0;			
			do {
				$style = $single_count - ( $i * count($styles) );
				$i++;
			} while ( $style > count($styles) );
		}
		
		// print('<pre>');
		// print_r($single_count);

		// print_r($single_count);

		// print_r($this->args_single['single_count']);

		// print_r($this->args['per_row']);

		// print_r( $this->args_single['single_count'] % $this->args['per_row']  );

		// print_r($styles_count);

		// print_r($styles);
		// print_r($this->args);
		// print_r($this->args_single);
		// print('</pre>');

		
		$last = $this->args_single['single_count'] % $this->args['per_row'] == 0 ? ' last' : '' ;
		$r = '';
		
		$r .= '<div class="view view-' . $style . $last . '">';
		
			$r .= $is_linked ? '<a href="' . $query_single_obj['link'] . '" class="info">' : '' ;
			$r .= '<div class="view-inner">';
			
				$r .= '<img src="' . $query_single_obj['image_url'] . '" />';
				
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