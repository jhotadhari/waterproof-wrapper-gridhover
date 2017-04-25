<?php
/*
Plugin Name: Waterproof Wrapper Gridhover
Plugin URI: http://waterproof-webdesign.info/waterproof-wrapper-gridhover
Description: A grid layout wrapper. Uses pure CSS3 effects on hover.
Version: 0.0.4
Author: jhotadhari
Author URI: http://waterproof-webdesign.info/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpwq-gh
Domain Path: /languages
Tags: shortcode,wrapper,lists,listing,css3,hover,grid
*/

/*
	grunt.concat_in_order.declare('_plugin_info');
*/

?>
<?php
/*
	grunt.concat_in_order.declare('init');
	grunt.concat_in_order.require('_plugin_info');
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wpwqgh_get_required_php_ver() {
	return '5.6';
}

function wpwqgh_plugin_activate(){
    if ( ! is_plugin_active( 'waterproof-wrap-query/waterproof-wrap-query.php' )
    	|| version_compare( PHP_VERSION, wpwqgh_get_required_php_ver(), '<')
    ) {
        wp_die( wpwqgh_get_admin_notice() . '<br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}
register_activation_hook( __FILE__, 'wpwqgh_plugin_activate' );

function wpwqgh_load_functions(){
	if (
		class_exists( 'Wpwq_wrapper' )
		&& ! version_compare( PHP_VERSION, wpwqgh_get_required_php_ver(), '<')
	){
		include_once(plugin_dir_path( __FILE__ ) . 'functions.php');
	} else {
		add_action( 'admin_notices', 'wpwqgh_print_admin_notice' );
	}
}
add_action( 'plugins_loaded', 'wpwqgh_load_functions' );

function wpwqgh_print_admin_notice() {
	echo '<strong><span style="color:#f00;">' . wpwqgh_get_admin_notice() . '</span></strong>';
};

function wpwqgh_get_admin_notice() {
	$plugin_title = 'Waterproof Wrapper Gridhover';
	$parent_plugin_title = 'Waterproof Wrap Query';
	return sprintf(esc_html__( '"%s" plugin requires "%s" plugin to be installed and activated and PHP version greater %s!', 'wpwq' ), $plugin_title, $parent_plugin_title, wpwqgh_get_required_php_ver());
}
?>