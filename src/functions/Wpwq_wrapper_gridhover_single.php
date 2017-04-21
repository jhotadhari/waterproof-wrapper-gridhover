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